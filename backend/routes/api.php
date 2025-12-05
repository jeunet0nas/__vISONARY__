<?php

use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('user', function(Request $req){
        return [
            'user' => UserResource::make($req->user()),
            'access_token' => $req->bearerToken()
        ];
    });
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::put('user/profile/update', [UserController::class, 'UpdateUserProfile']);

    Route::post('apply/coupon', [CouponController::class, 'applyCoupon']);
});


Route::get('products', [ProductController::class, 'index']);
Route::get('products/{searchTerm}/find', [ProductController::class, 'findProductsByTerm']);
Route::get('products/{collection}/collection', [ProductController::class, 'filterProductsByCollection']);
Route::get('products/{product}/show', [ProductController::class, 'show']);

Route::post('user/register', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'auth']);
