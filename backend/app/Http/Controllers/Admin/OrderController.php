<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $req){
        $query = Order::query();
        if($req->has('start_date') && $req->has('end_date')){
            $start_date = $req->start_date;
            $end_date = $req->end_date;
            if(Carbon::parse($start_date)->gt(Carbon::parse($end_date))){
                return redirect()->route('admin.orders.index')->withErrors([
                    'start_date' => 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc'
                ]);
            }
            $query->whereBetween('created_at', [$start_date, $end_date]);

        }

        $orders = $query->with('customer', 'coupon')->get();
        return view('admin.orders.index')->with([
            'orders' => $orders
        ]);
    }

    public function updateDeliveredDate(Order $order){
        $order->update([
            'delivered_at' => Carbon::now(),
            'payment_status' => 'paid'
        ]);
        return redirect()->route('admin.orders.index')->with([
            'success' => 'Đơn hàng đã được giao thành công'
        ]);
    }

    public function show($order_id){
        $order = Order::with('products', 'customer', 'coupon')->findOrFail($order_id);
        return view('admin.orders.show')->with([
            'order' => $order
        ]);
    }

    public function destroy(Order $order){
        $order->delete();
        return redirect()->route('admin.orders.index')->with([
            'success' => 'Đơn hàng đã được xóa thành công'
        ]);
    }
}
