<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('shipping_add');
            $table->string('order_phone');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->string('payment_method');
            $table->string('payment_status');
            $table->datetime('delivered_at')->nullable();
            $table->foreignId('customer_id')->constrained('customers', 'customer_id')->cascadeOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons', 'coupon_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
