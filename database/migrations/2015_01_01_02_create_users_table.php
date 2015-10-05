<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('token');
            $table->rememberToken();
            $table->integer('typeUser_id')->unsigned()->index();
            $table->foreign('typeUser_id')->references('id')->on('typeUsers')->onDelete('no action');
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
        Schema::drop('users');
    }
}
