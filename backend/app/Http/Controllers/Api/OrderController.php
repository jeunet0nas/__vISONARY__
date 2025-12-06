<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $orders = Order::where('customer_id', $user->customer_id)->with(['products', 'coupon'])
->orderBy('created_at', 'desc')->get()->map(function ($order) {
                return [
                    'id' => $order->order_id,
                    'total_amount' => $order->grand_total,
                    'subtotal' => $order->subtotal,
                    'discount_amount' => $order->discount_amount,
                    'payment_method' => strtolower($order->payment_method),
                    'payment_status' => $order->payment_status,
                    'shipping_address' => $order->shipping_add,
                    'created_at' => $order->created_at,
                    'status' => $order->payment_status,
                    'status_label' => $order->payment_status === 'completed' ? 'Giao thành công' : 'Đang xử lý',
                    'items' => $order->products->map(function ($product) {
                        return [
                            'product_name' => $product->product_name,
                            'slug' => $product->slug,
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
            'payment_method' => 'required|in:cod,qr',
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
                    'item_price' => $item['price'],          // Giá gốc tại thời điểm đặt
                    'item_qty' => $item['quantity'],
                    'item_subtotal' => $itemSubtotal,        // Tổng tiền từng item
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
}
