<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){

});


Route::get('products', [ProductController::class, 'index']);
Route::get('products/{searchTerm}/find', [ProductController::class, 'findProductsByTerm']);
Route::get('products/{collection}/collection', [ProductController::class, 'filterProductsByCollection']);
Route::get('products/{product}/show', [ProductController::class, 'show']);
