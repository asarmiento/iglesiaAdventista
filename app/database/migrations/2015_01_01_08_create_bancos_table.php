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
            $table->string('name');
            $table->decimal('saldo', 20, 2);
            $table->integer('ingresos_id')->unsigned()->index();
            $table->foreign('ingresos_id')->references('id')->on('ingresos')->onDelete('no action');
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
