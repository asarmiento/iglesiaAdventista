<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMiembrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('miembros', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('last');
			$table->date('date_bautizmo');
			$table->date('date_nacimiento');
			$table->string('phone');
			$table->string('celular');
			$table->string('email');
			$table->integer('iglesias_id');
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
		Schema::drop('miembros');
	}

}
