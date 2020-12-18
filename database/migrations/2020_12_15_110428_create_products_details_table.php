<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id');
            $table->integer('brand_id')->unsigned();
            $table->integer('cy_id')->unsigned();
            $table->integer('price')->unsigned();
            $table->string('name');
            $table->boolean('is_available')->default(true);
            $table->boolean('published')->default(true);
            $table->string('model')->nullable();
            $table->text('description')->nullable();
            $table->string('description_short')->nullable();
            $table->string('image')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_details');
    }
}
