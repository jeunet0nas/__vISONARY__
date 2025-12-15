<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $orders = Order::where('customer_id', $user->customer_id)
            ->with(['products', 'coupon', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->order_id,
                    'total_amount' => $order->grand_total,
                    'subtotal' => $order->subtotal,
                    'discount_amount' => $order->discount_amount,
                    'payment_method' => strtolower($order->payment_method),
                    'payment_status' => $order->payment_status,
                    'shipping_address' => $order->shipping_add,
                    'order_phone' => $order->order_phone,
                    'customer_name' => $order->customer->customer_name,
                    'customer_email' => $order->customer->email,
                    'created_at' => $order->created_at,
                    'delivered_at' => $order->delivered_at,
                    'status' => $order->payment_status,
                    'status_label' => is_null($order->delivered_at)
                        ? 'Đang vận chuyển'
                        : 'Giao thành công',
                    'items' => $order->products->map(function ($product) {
                        return [
                            'product_id' => $product->product_id,
                            'product_name' => $product->product_name,
                            'product_slug' => $product->slug,
                            'thumbnail' => $product->thumbnail,
                            'quantity' => $product->pivot->item_qty,
                            'price' => $product->pivot->item_price,
                            'subtotal' => $product->pivot->item_subtotal,
                        ];
                    }),
                    'coupon' => $order->coupon ? [
                        'code' => $order->coupon->coupon_name,
                        'discount' => $order->coupon->discount,
                    ] : null,
                ];
            });

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'coupon_code' => 'nullable|string',
            'payment_method' => 'required|in:cod,qr,stripe',
        ]);

        DB::beginTransaction();
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để đặt hàng'
                ], 401);
            }

            $coupon = null;
            if (!empty($validated['coupon_code'])) {
                $coupon = Coupon::where('coupon_name', strtoupper($validated['coupon_code']))->first();
            }

            $order = Order::create([
                'customer_id' => $user->customer_id,
                'shipping_add' => $validated['shipping_address'],
                'order_phone' => $validated['customer_phone'],
                'subtotal' => $validated['subtotal'],
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'grand_total' => $validated['total_amount'],
                'payment_method' => strtoupper($validated['payment_method']),
                'payment_status' => 'pending',
                'coupon_id' => $coupon ? $coupon->coupon_id : null,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    throw new \Exception("Sản phẩm ID {$item['product_id']} không tồn tại");
                }

                if ($product->product_qty < $item['quantity']) {
                    throw new \Exception("Sản phẩm '{$product->product_name}' không đủ số lượng. Còn lại: {$product->product_qty}");
                }

                $itemSubtotal = $item['price'] * $item['quantity'];

                $order->products()->attach($product->product_id, [
                    'item_price' => $item['price'],
                    'item_qty' => $item['quantity'],
                    'item_subtotal' => $itemSubtotal,
                ]);

                // Trừ tồn kho
                $product->decrement('product_qty', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công!',
                'order_id' => $order->order_id,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Tạo Stripe Checkout Session để thanh toán
     * Flow MỚI: Frontend gọi API → Validate stock → Tạo Stripe session với metadata → User thanh toán
     * → Webhook tạo order nếu thành công → Không có order nếu user hủy
     */
    public function createStripeCheckout(Request $request)
    {
        $validated = $request->validate([
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,product_id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'coupon_code' => 'nullable|string',
        ]);

        try {
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để đặt hàng'
                ], 401);
            }

            // Validate stock TRƯỚC KHI tạo Stripe session
            $lineItems = [];
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    throw new \Exception("Sản phẩm ID {$item['product_id']} không tồn tại");
                }

                if ($product->product_qty < $item['quantity']) {
                    throw new \Exception("Sản phẩm '{$product->product_name}' không đủ số lượng. Còn lại: {$product->product_qty}");
                }

                // Chuẩn bị line items cho Stripe
                $lineItems[] = [
                    'price_data' => [
                        'currency' => config('stripe.currency', 'vnd'),
                        'product_data' => [
                            'name' => $product->product_name,
                            'images' => [$product->thumbnail ? url($product->thumbnail) : null],
                            'description' => substr($product->product_desc ?? '', 0, 200),
                        ],
                        'unit_amount' => (int) $item['price'],
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            // Thêm discount nếu có
            if ($validated['discount_amount'] > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => config('stripe.currency', 'vnd'),
                        'product_data' => [
                            'name' => 'Giảm giá' . ($validated['coupon_code'] ? " ({$validated['coupon_code']})" : ''),
                        ],
                        'unit_amount' => -(int) $validated['discount_amount'],
                    ],
                    'quantity' => 1,
                ];
            }

            // Khởi tạo Stripe
            Stripe::setApiKey(config('stripe.secret_key'));

            // LƯU TẤT CẢ order data vào metadata để webhook tạo order sau
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => config('stripe.success_url') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => config('stripe.cancel_url'),
                'customer_email' => $user->email,
                'metadata' => [
                    // User info
                    'customer_id' => $user->customer_id,
                    'customer_name' => $user->customer_name,
                    'customer_email' => $user->email,

                    // Order info
                    'shipping_address' => $validated['shipping_address'],
                    'customer_phone' => $validated['customer_phone'],
                    'subtotal' => $validated['subtotal'],
                    'discount_amount' => $validated['discount_amount'] ?? 0,
                    'grand_total' => $validated['total_amount'],
                    'coupon_code' => $validated['coupon_code'] ?? '',

                    // Items (JSON encoded vì metadata chỉ accept string)
                    'items' => json_encode($validated['items']),
                ],
                'expires_at' => now()->addMinutes(30)->timestamp,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Stripe checkout session đã được tạo',
                'checkout_url' => $session->url,
                'session_id' => $session->id,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Xử lý Stripe Webhook Events
     * Flow MỚI: Chỉ tạo order KHI checkout.session.completed
     * Nếu user hủy/đóng trang → Không có order nào được tạo
     */
    public function handleStripeWebhook(Request $request)
    {
        $webhookSecret = config('stripe.webhook_secret');

        if (empty($webhookSecret)) {
            Log::warning('Stripe webhook secret chưa được cấu hình!');
        }

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            if (!empty($webhookSecret)) {
                $event = \Stripe\Webhook::constructEvent(
                    $payload,
                    $sigHeader,
                    $webhookSecret
                );
            } else {
                $event = json_decode($payload, false);
            }
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe webhook invalid payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook invalid signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                // TẠO ORDER mới khi thanh toán thành công
                $session = $event->data->object;
                $metadata = $session->metadata;

                DB::beginTransaction();
                try {
                    // Parse items từ metadata
                    $items = json_decode($metadata->items, true);

                    // Tìm hoặc tạo coupon nếu có
                    $couponId = null;
                    if (!empty($metadata->coupon_code)) {
                        $coupon = Coupon::where('coupon_name', strtoupper($metadata->coupon_code))->first();
                        $couponId = $coupon ? $coupon->coupon_id : null;
                    }

                    // TẠO ORDER với status = 'paid' luôn
                    $order = Order::create([
                        'customer_id' => $metadata->customer_id,
                        'shipping_add' => $metadata->shipping_address,
                        'order_phone' => $metadata->customer_phone,
                        'subtotal' => $metadata->subtotal,
                        'discount_amount' => $metadata->discount_amount ?? 0,
                        'grand_total' => $metadata->grand_total,
                        'payment_method' => 'STRIPE',
                        'payment_status' => 'paid', // Đã thanh toán thành công
                        'coupon_id' => $couponId,
                    ]);

                    // Attach products và trừ tồn kho
                    foreach ($items as $item) {
                        $product = Product::find($item['product_id']);

                        if (!$product) {
                            throw new \Exception("Sản phẩm ID {$item['product_id']} không tồn tại");
                        }

                        // Kiểm tra stock lần cuối (có thể đã hết trong lúc user thanh toán)
                        if ($product->product_qty < $item['quantity']) {
                            // Log warning nhưng vẫn tạo order (cần xử lý manual)
                            Log::warning("Order #{$order->order_id}: Sản phẩm {$product->product_name} không đủ stock!");
                        }

                        $itemSubtotal = $item['price'] * $item['quantity'];

                        $order->products()->attach($product->product_id, [
                            'item_price' => $item['price'],
                            'item_qty' => $item['quantity'],
                            'item_subtotal' => $itemSubtotal,
                        ]);

                        // Trừ tồn kho (chỉ khi chắc chắn thanh toán thành công)
                        $product->decrement('product_qty', $item['quantity']);
                    }

                    DB::commit();
                    Log::info("Order #{$order->order_id} đã được tạo và thanh toán thành công qua Stripe");

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Stripe webhook create order failed: ' . $e->getMessage());
                }
                break;

            case 'checkout.session.expired':
                // User không hoàn tất → KHÔNG CÓ ORDER nào được tạo → KHÔNG CẦN XỬ LÝ GÌ
                Log::info('Checkout session expired - no order created');
                break;

            case 'payment_intent.payment_failed':
                Log::warning('Stripe payment failed', ['event' => $event]);
                break;

            default:
                Log::info('Stripe webhook unhandled event type: ' . $event->type);
        }

        return response()->json(['received' => true]);
    }

    /**
     * Verify Stripe session sau khi user redirect về success page
     * Flow MỚI:
     * 1. Tìm order đã được tạo bởi webhook
     * 2. Nếu chưa có (webhook chưa chạy/failed) → TẠO ORDER NGAY (fallback)
     */
    public function verifyStripeSession(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
        ]);

        try {
            Stripe::setApiKey(config('stripe.secret_key'));

            $session = Session::retrieve($validated['session_id']);

            // Kiểm tra session có hợp lệ không
            if ($session->payment_status !== 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Thanh toán chưa hoàn tất',
                ], 400);
            }

            $metadata = $session->metadata;

            // Tìm order đã được tạo bởi webhook
            $order = Order::where('customer_id', $metadata->customer_id)
                ->where('grand_total', $metadata->grand_total)
                ->where('payment_method', 'STRIPE')
                ->where('payment_status', 'paid')
                ->latest()
                ->first();

            // FALLBACK: Nếu webhook chưa tạo order → TẠO NGAY
            if (!$order) {
                Log::warning("Webhook chưa tạo order cho session {$session->id}, tạo order fallback...");

                DB::beginTransaction();
                try {
                    // Parse items từ metadata
                    $items = json_decode($metadata->items, true);

                    // Tìm hoặc tạo coupon nếu có
                    $couponId = null;
                    if (!empty($metadata->coupon_code)) {
                        $coupon = Coupon::where('coupon_name', strtoupper($metadata->coupon_code))->first();
                        $couponId = $coupon ? $coupon->coupon_id : null;
                    }

                    // TẠO ORDER
                    $order = Order::create([
                        'customer_id' => $metadata->customer_id,
                        'shipping_add' => $metadata->shipping_address,
                        'order_phone' => $metadata->customer_phone,
                        'subtotal' => $metadata->subtotal,
                        'discount_amount' => $metadata->discount_amount ?? 0,
                        'grand_total' => $metadata->grand_total,
                        'payment_method' => 'STRIPE',
                        'payment_status' => 'paid',
                        'coupon_id' => $couponId,
                    ]);

                    // Attach products và trừ tồn kho
                    foreach ($items as $item) {
                        $product = Product::find($item['product_id']);

                        if (!$product) {
                            throw new \Exception("Sản phẩm ID {$item['product_id']} không tồn tại");
                        }

                        if ($product->product_qty < $item['quantity']) {
                            Log::warning("Order #{$order->order_id}: Sản phẩm {$product->product_name} không đủ stock!");
                        }

                        $itemSubtotal = $item['price'] * $item['quantity'];

                        $order->products()->attach($product->product_id, [
                            'item_price' => $item['price'],
                            'item_qty' => $item['quantity'],
                            'item_subtotal' => $itemSubtotal,
                        ]);

                        $product->decrement('product_qty', $item['quantity']);
                    }

                    DB::commit();
                    Log::info("Order #{$order->order_id} được tạo bởi verifyStripeSession (fallback)");

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('verifyStripeSession create order failed: ' . $e->getMessage());
                    throw $e;
                }
            }

            return response()->json([
                'success' => true,
                'payment_status' => $session->payment_status,
                'order' => [
                    'id' => $order->order_id,
                    'status' => $order->payment_status,
                    'total' => $order->grand_total,
                    'customer_name' => $metadata->customer_name,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xác thực: ' . $e->getMessage(),
            ], 400);
        }
    }
}
