<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('published')->default(true);
            $table->integer('image_id')->default(0);
            $table->text('description')->nullable();
            $table->string('description_short')->nullable();
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
        Schema::table('categories', function(Blueprint $table){
            $table->dropForeign('subcategories_child_category_id_foreign');
            $table->dropForeign('subcategories_parent_category_id_foreign');
            $table->dropForeign('products_categories_category_id_foreign');
        });
        Schema::dropIfExists('categories');
    }
}
