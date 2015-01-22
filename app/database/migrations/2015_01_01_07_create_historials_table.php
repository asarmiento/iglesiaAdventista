<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHistorialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('numero');
                        $table->string('num_control');
			$table->date('sabado');
                        $table->decimal('saldo',20,2);
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
	public function down()
	{
		Schema::drop('historials');
	}

}
