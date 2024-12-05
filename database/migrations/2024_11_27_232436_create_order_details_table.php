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
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
        // Tabel order_details
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_detail_id'); // ID unik untuk setiap detail
            $table->unsignedBigInteger('order_id'); // ID order yang terkait
            $table->unsignedBigInteger('product_id'); // ID produk yang dipesan
            $table->unsignedBigInteger('product_size_id'); // ID ukuran produk yang dipesan
            $table->integer('quantity'); // Jumlah produk yang dipesan
            $table->integer('price'); // Harga per unit produk
            $table->integer('subtotal'); // Total harga untuk produk ini (quantity * price)
            $table->timestamps(); // Kolom created_at dan updated_at
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->foreign('product_size_id')->references('id')->on('product_sizes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('product_sizes');
    
    }
};
