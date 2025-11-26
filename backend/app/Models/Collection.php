<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $primaryKey = 'collection_id';
    protected $fillable = [
        'collection_name',
        'slug',
        'released',
        'collection_desc',
        'banner_img'
    ];

    public function products(){
        return $this->hasMany(Product::class, 'collection_id', 'collection_id');
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
