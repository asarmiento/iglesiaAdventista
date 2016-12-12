<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeExpenseTypeIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('type_expense_type_income', function(Blueprint $table) {
            $table->integer('type_expense_id')->unsigned()->index();
            $table->foreign('type_expense_id')->references('id')->on('type_expenses')->onDelete('cascade');
            $table->integer('type_income_id')->unsigned()->index();
            $table->foreign('type_income_id')->references('id')->on('type_incomes')->onDelete('cascade');
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
        Schema::drop('type_expense_type_income');
    }
}
