<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_expenses', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('balance', 20, 2);
            $table->integer('departament_id')->unsigned()->index();
            $table->foreign('departament_id')->references('id')->on('departaments')->onDelete('no action');
            $table->integer('church_id')->unsigned()->index();
            $table->foreign('church_id')->references('id')->on('churchs')->onDelete('no action');
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
        Schema::drop('type_expenses');
    }
}
