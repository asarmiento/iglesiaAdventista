<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('remember_token');
            $table->integer('tipos_users_id')->unsigned()->index();
             $table->foreign('tipos_users_id')->references('id')->on('tipos_users')->onDelete('cascade');
             $table->integer('iglesias_id')->unsigned()->index();
             $table->foreign('iglesias_id')->references('id')->on('iglesias')->onDelete('cascade');
             $table->engine = 'InnoDB';
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }

}
