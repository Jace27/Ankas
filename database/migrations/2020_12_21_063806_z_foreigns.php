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
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('cy_id')->references('id')->on('cys')->onDelete('cascade');
        });
        Schema::table('products_categories', function(Blueprint $table){
            $table->foreign('products_detail_id')->references('id')->on('products_details')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('orders_products', function (Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products_details')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
        Schema::table('subcategories', function (Blueprint $table){
            $table->foreign('parent_category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('child_category_id')->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('users', function (Blueprint $table){
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
        Schema::table('role_rights', function (Blueprint $table){
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('right_id')->references('id')->on('rights')->onDelete('cascade');
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
