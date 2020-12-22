<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->string('symbol');
        });

        App\Models\cys::insert(array(
            array(
                'name' => 'Рубль',
                'code' => 'RUB',
                'symbol' => 'руб.'
            ),
            array(
                'name' => 'Доллар',
                'code' => 'USD',
                'symbol' => '$'
            ),
            array(
                'name' => 'Евро',
                'code' => 'EUR',
                'symbol' => 'евро'
            ),
            array(
                'name' => 'Тенге',
                'code' => 'KZT',
                'symbol' => 'тенге'
            ),
            array(
                'name' => 'Юань',
                'code' => 'CNY',
                'symbol' => 'юаней'
            ),
            array(
                'name' => 'Иена',
                'code' => 'JPY',
                'symbol' => 'иен'
            ),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cys', function (Blueprint $table){
            $table->dropForeign('products_details_cy_id_foreign');
        });
        Schema::dropIfExists('cys');
    }
}
