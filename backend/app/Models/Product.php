<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name',
        'slug',
        'released_at',
        'product_price',
        'product_qty',
        'material',
        'shape',
        'product_desc',
        'thumbnail',
        'first_img',
        'second_img',
        'third_img',
        'fourth_img',
        'status',
        'color_id',
        'collection_id'
    ];

    public function collection(){
        return $this->belongsTo(Collection::class, 'collection_id', 'collection_id');
    }

    public function color(){
        return $this->belongsTo(Color::class, 'color_id', 'color_id');
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')->withPivot('item_price', 'item_qty');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'review_id', 'review_id')->with('customer')->where('approved', 1)->latest();
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
