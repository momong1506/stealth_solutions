<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('products_id');
            $table->unsignedBigInteger('categories_id');
            $table->timestamps();

            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->index(['products_id']);

            $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->index(['categories_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
}
