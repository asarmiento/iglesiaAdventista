<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiposVariablesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tipos_variables', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('saldo', 20, 2);
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
        Schema::drop('tipos_variables');
    }

}
