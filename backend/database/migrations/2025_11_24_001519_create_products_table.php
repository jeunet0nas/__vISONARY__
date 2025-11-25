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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->string('slug')->unique();
            $table->string('released_at');
            $table->string('product_price');
            $table->string('product_qty');
            $table->string('material');
            $table->string('shape');
            $table->string('product_desc');
            $table->string('thumbnail');
            $table->string('first_img')->nullable();
            $table->string('second_img')->nullable();
            $table->string('third_img')->nullable();
            $table->string('fourth_img')->nullable();
            $table->boolean('status')->default(1);
            $table->foreignId('collection_id')->constrained('collections', 'collection_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
