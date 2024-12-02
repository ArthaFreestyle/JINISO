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
        Schema::create('products',function (Blueprint $table){
            $table->id('product_id')->primary();
            $table->string('product_name',200);
            $table->string('slug');
            $table->string('thumbnail');
            $table->text('description');
            $table->integer('price');
            $table->integer('stock');
            $table->boolean('isPopular');
            $table->softDeletes();
            $table->unsignedBigInteger('category_id'); 
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->timestamps(); 
        });

        Schema::create('product_image',function(Blueprint $table){
            $table->id();
            $table->string('image');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
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
