<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('last');
			$table->string('email');
			$table->string('password');
			$table->string('remember_token');
			$table->integer('tipo_user_id');
			$table->integer('iglesias_id');
			$table->foreign('tipo_user_id')->references('id')->on('tipo_user');
			$table->foreign('iglesias_id')->references('id')->on('iglesias');
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
