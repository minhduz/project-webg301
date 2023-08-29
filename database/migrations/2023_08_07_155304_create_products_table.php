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
            $table->string('name');
            $table->float('price');
            $table->text('description')->nullable();
            $table->text('main_image_url');
            $table->float('weight')->nullable();
            $table->boolean('status');
            $table->unsignedBigInteger('catalog_id');
            $table->foreign('catalog_id')->references('catalog_id')->on('catalogs');
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
