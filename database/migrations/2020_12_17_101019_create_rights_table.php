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
                'name' => 'Добавить категорию',
                'description' => ''
            ),
            array(
                'name' => 'Изменить категорию',
                'description' => ''
            ),
        ));
/*
        $right = new App\Models\rights();
        $right->name = 'Добавить товар';
        $right->save();

        $right = new App\Models\rights();
        $right->name = 'Изменить товар';
        $right->save();

        $right = new App\Models\rights();
        $right->name = 'Добавить категорию';
        $right->save();

        $right = new App\Models\rights();
        $right->name = 'Изменить категорию';
        $right->save();*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rights');
    }
}
