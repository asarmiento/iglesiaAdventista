<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentBaseIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departament_base_incomes', function(Blueprint $table) {
            $table->increments('id',true);
            $table->date('date');
            $table->decimal('amount', 20, 2);
            $table->integer('type_income_id')->unsigned()->index();
            $table->foreign('type_income_id')->references('id')->on('type_incomes')->onDelete('no action');
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
        Schema::drop('departament_base_incomes');
    }
}
