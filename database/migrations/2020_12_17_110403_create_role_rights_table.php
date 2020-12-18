<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_rights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role');
            $table->integer('right');
        });

        App\Models\role_right::insert(array(
            array(
                'role' => 1,
                'right' => 1
            ),
            array(
                'role' => 1,
                'right' => 2
            ),
            array(
                'role' => 1,
                'right' => 3
            ),
            array(
                'role' => 1,
                'right' => 4
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
        Schema::dropIfExists('role_rights');
    }
}
