<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClosingBalanceOfDepartamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closing_balance_Of_departaments', function(Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('type_expense_id')->unsigned()->index();
            $table->foreign('type_expense_id')->references('id')->on('expenses')->onDelete('cascade');
            $table->decimal('amountExp',20,2);
            $table->integer('type_income_id')->unsigned()->index();
            $table->foreign('type_income_id')->references('id')->on('type_incomes')->onDelete('cascade');
            $table->decimal('amountInc',20,2);
            $table->engine = 'InnoDB';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('closing_balance_Of_departaments');
    }
}
