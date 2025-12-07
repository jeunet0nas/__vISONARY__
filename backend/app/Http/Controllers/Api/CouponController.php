<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function applyCoupon(Request $req){
        $subtotal = $req->subtotal ?? 0;

        if ($subtotal <= 0) {
            return response()->json([
                'error' => 'Đơn hàng chưa đủ giá trị tối thiểu để áp dụng mã!'
            ]);
        }

        $coupon = Coupon::where('coupon_name', $req->coupon_name)->first();
        if($coupon && $coupon->checkIfValid()){
            if($subtotal >= $coupon->min_total){
                return response()->json([
                    'message' => 'Áp dụng mã khuyến mãi thành công!',
                    'coupon' => $coupon
                ]);
            } else {
                return response()->json([
                    'error' => 'Đơn hàng chưa đủ giá trị tối thiểu để áp dụng mã!'
                ]);
            }
        } else{
            return response()->json([
                'error' => 'Mã áp dụng hết hạn hoặc không hợp lệ!'
            ]);
        }
    }
}
