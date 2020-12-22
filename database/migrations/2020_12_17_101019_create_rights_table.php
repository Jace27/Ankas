<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rights', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('description');
        });

        App\Models\rights::insert(array(
            array(
                'name' => 'Добавить товар',
                'description' => ''
            ),
            array(
                'name' => 'Изменить товар',
                'description' => ''
            ),
            array(
                'name' => 'Удалить товар',
                'description' => ''
            ),
            array(
                'name' => 'Добавить категорию',
                'description' => ''
            ),
            array(
                'name' => 'Изменить категорию',
                'description' => ''
            ),
            array(
                'name' => 'Удалить категорию',
                'description' => ''
            ),
            array(
                'name' => 'Просмотреть все заказы',
                'description' => ''
            ),
            array(
                'name' => 'Изменить статус заказа',
                'description' => ''
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
        Schema::table('rights', function(Blueprint $table){
            $table->dropForeign('role_rights_right_id_foreign');
        });
        Schema::dropIfExists('rights');
    }
}
