<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;
    protected $primaryKey = 'coupon_id';
    protected $fillable = [
        'coupon_name',
        'discount',
        'min_total',
        'valid_until'
    ];

    public function setCouponNameAttribute($value){
        $this->attributes['coupon_name'] = Str::upper($value);
    }

    public function checkIfValid(){
        if($this->valid_until > Carbon::now()){
            return true;
        } else{
            return false;
        }
    }
}
