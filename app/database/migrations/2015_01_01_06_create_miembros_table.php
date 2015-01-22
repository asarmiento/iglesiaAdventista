<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMiembrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('miembros', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 80);
            $table->string('last', 80);
            $table->date('date_bautizmo');
            $table->date('date_nacimiento');
            $table->string('phone', 10);
            $table->string('celular', 10);
            $table->string('email');
            $table->integer('iglesias_id')->unsigned()->index();
            $table->foreign('iglesias_id')->references('id')->on('iglesias')->onDelete('no action');
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
        Schema::drop('miembros');
    }

}
