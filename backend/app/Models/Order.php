<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'shipping_add',
        'order_phone',
        'subtotal',
        'discount_amount',
        'grand_total',
        'payment_method',
        'payment_status',
        'delivered_at',
        'customer_id',
        'coupon_id'
    ];

    public function setStatus($value){
        $this->payment_status = $value;
    }

    public function customer(){
        return $this->belongsTo(User::class, 'customer_id', 'customer_id');
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class, 'coupon_id', 'coupon_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')
            ->withPivot('item_price', 'item_qty', 'item_subtotal')
            ->withTimestamps();
    }

    // Giữ nguyên created_at format gốc cho API
    // public function getCreatedAtAttribute($value){
    //     return Carbon::parse($value)->diffForHumans();
    // }
}
