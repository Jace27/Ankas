<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ZForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_details', function (Blueprint $table){
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('cy_id')->references('id')->on('cys');
        });
        Schema::table('products_categories', function(Blueprint $table){
            $table->foreign('products_detail_id')->references('id')->on('products_details');
            $table->foreign('category_id')->references('id')->on('categories');
        });
        Schema::table('orders_products', function (Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products_details');
            $table->foreign('order_id')->references('id')->on('orders');
        });
        Schema::table('subcategories', function (Blueprint $table){
            $table->foreign('parent_category_id')->references('id')->on('categories');
            $table->foreign('child_category_id')->references('id')->on('categories');
        });
        Schema::table('users', function (Blueprint $table){
            $table->foreign('role_id')->references('id')->on('roles');
        });
        Schema::table('role_rights', function (Blueprint $table){
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('right_id')->references('id')->on('rights');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
