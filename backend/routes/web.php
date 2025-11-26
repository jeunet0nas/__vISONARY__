<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, "login"])->name("admin.login");
Route::post('admin/auth', [AdminController::class, "auth"])->name("admin.auth");

Route::prefix('admin')->middleware('admin')->group(function(){
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::resource('collections', CollectionController::class, [
        'names' => [
            'index' => 'admin.collections.index',
            'create' => 'admin.collections.create',
            'store' => 'admin.collections.store',
            'edit' => 'admin.collections.edit',
            'update' => 'admin.collections.update',
            'destroy' => 'admin.collections.destroy'
        ]
    ]);

    Route::resource('products', ProductController::class, [
        'names' => [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy'
        ]
    ]);
});
