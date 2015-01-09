<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIngresosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ingresos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('num_informe');
			$table->integer('num_sobre');
			$table->integer('num_control');
			$table->date('date');
			$table->decimal('monto',[20,2]);
			$table->integer('miembros_id');
			$table->integer('tipos_fijos_id');
			$table->integer('tipos_variables_id')->nullable();
			$table->foreign('miembros_id')->references('id')->on('miembros');
			$table->foreign('tipos_fijos_id')->references('id')->on('tipos_fijos');
			$table->foreign('tipos_variables_id')->references('id')->on('tipos_variables');
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
		Schema::drop('ingresos');
	}

}
