<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->unique();
            $table->timestamps();
        });

        \App\Models\images::insert([
            [ 'file_name' => '/images/default-image.png' ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_details', function (Blueprint $table){
            $table->dropForeign('products_details_image_id_foreign');
        });
        Schema::table('categories', function(Blueprint $table){
            $table->dropForeign('categories_image_id_foreign');
        });
        Schema::dropIfExists('images');
    }
}
