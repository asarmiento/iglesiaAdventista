<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIngresosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ingresos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('historial_id')->unsigned()->index();
            $table->foreign('historial_id')->references('id')->on('historial')->onDelete('no action');
            $table->integer('num_sobre');
            $table->integer('num_control');
            $table->date('date');
            $table->decimal('monto', 20, 2);
            $table->integer('miembros_id')->unsigned()->index();
            $table->foreign('miembros_id')->references('id')->on('miembros')->onDelete('no action');
            $table->integer('tipos_fijos_id')->unsigned()->nullable()->index();
            $table->foreign('tipos_fijos_id')->references('id')->on('tipos_fijos')->onDelete('no action');
            $table->integer('tipos_variables_id')->unsigned()->nullable()->index();
            $table->foreign('tipos_variables_id')->references('id')->on('tipos_variables')->onDelete('no action');
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
        Schema::drop('ingresos');
    }

}
