<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBancosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('bancos', function(Blueprint $table) {
            $table->increments('id');
            $table->decimal('saldo', 20, 2);
            $table->date('date');
            $table->string('imagen');
            $table->enum('tipo', ['entradas', 'salidas']);
            $table->integer('historial_id')->unsigned()->nullable()->index();
            $table->foreign('historial_id')->references('id')->on('historials')->onDelete('no action');
            $table->integer('cheques_id')->unsigned()->nullable()->index();
            $table->foreign('cheques_id')->references('id')->on('cheques')->onDelete('no action');
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
        Schema::drop('bancos');
    }

}
