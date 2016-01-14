<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExpensesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('expenses', function(Blueprint $table) {
            $table->increments('id');
            $table->string('invoiceNumber');
            $table->date('date');
            $table->date('invoiceDate');
            $table->decimal('amount', 20, 2);
            $table->text('detail');
            $table->string('imagen');
            $table->integer('departament_id')->unsigned()->index();
            $table->foreign('departament_id')->references('id')->on('departaments')->onDelete('no action');
            $table->integer('check_id')->unsigned()->index();
            $table->foreign('check_id')->references('id')->on('checks')->onDelete('no action');
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
        Schema::drop('expenses');
    }

}
