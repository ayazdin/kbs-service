<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->tinyIncrements('id');
            $table->string('slug', 20);
            $table->string('name', 20);
            $table->timestamps();
        });

        DB::table('roles')->insert(['slug' => 'admin', 'name' => 'Admin']);
        DB::table('roles')->insert(['slug' => 'user', 'name' => 'User']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
