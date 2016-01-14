<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBanksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('banks', function(Blueprint $table) {
            $table->increments('id');
            $table->decimal('balance', 20, 2);
            $table->date('date');
            $table->string('url');
            $table->enum('type', ['entradas', 'salidas']);
            $table->integer('record_id')->unsigned()->nullable()->index();
            $table->foreign('record_id')->references('id')->on('records')->onDelete('no action');
            $table->integer('account_check_id')->unsigned()->nullable()->index();
            $table->foreign('account_check_id')->references('id')->on('account_check')->onDelete('no action');
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
        Schema::drop('banks');
    }

}
