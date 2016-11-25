<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeIncomesOfTypeExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_incomes_of_type_expenses', function(Blueprint $table) {
            $table->integer('type_income_id')->unsigned()->nullable()->index();
            $table->integer('type_expense_id')->unsigned()->nullable()->index();
            $table->engine = 'InnoDB';
            $table->timestamps();
        });

        Schema::table('type_incomes_of_type_expenses', function($table) {
            $table->foreign('type_income_id')->references('id')->on('type_incomes')->onDelete('cascade');
            $table->foreign('type_expense_id')->references('id')->on('type_expenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('type_incomes_of_type_expenses');
    }
}
