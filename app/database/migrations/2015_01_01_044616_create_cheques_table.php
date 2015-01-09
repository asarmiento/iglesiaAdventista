<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChequesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cheques', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('numero');
			$table->string('name');
			$table->date('date');
			$table->text('detalle');
			$table->string('monto');
			$table->integer('departamentos_id');
			$table->integer('banco_id');
			$table->foreign('departamentos_id')->references('id')->on('departamentos');
			$table->foreign('banco_id')->references('id')->on('bancos');
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
		Schema::drop('cheques');
	}

}
