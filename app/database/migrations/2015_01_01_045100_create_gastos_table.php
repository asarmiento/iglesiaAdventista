<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGastosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gastos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('num_factura');
			$table->date('date');
			$table->date('datefactura');
			$table->decimal('monto',[20,2]);
			$table->text('descripcion');
			$table->string('departamentos_id');
			$table->foreign('departamentos_id')->references('id')->on('departamentos');
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
		Schema::drop('gastos');
	}

}
