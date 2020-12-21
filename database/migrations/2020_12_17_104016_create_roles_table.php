<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
        });

        App\Models\roles::insert(array(
            array(
                'name' => 'Администратор',
                'description' => ''
            ),
            array(
                'name' => 'Пользователь',
                'description' => ''
            ),
            array(
                'name' => 'Менеджер',
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
        Schema::table('roles', function(Blueprint $table){
            $table->dropForeign('role_rights_role_id_foreign');
            $table->dropForeign('users_role_id_foreign');
        });
        Schema::dropIfExists('roles');
    }
}
