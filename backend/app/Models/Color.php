<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $primaryKey = 'color_id';
    protected $fillable = [
        'color_name'
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'color_product', 'color_id', 'product_id');
    }
}
