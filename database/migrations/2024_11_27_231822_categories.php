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
        Schema::create('categories',function(Blueprint $table){
            $table->id('category_id')->primary();
            $table->string('category_name');
            $table->string('slug');
            $table->string('icon');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });

       

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
