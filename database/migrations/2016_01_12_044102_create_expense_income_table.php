<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_income', function(Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount', 20, 2);
            $table->integer('expense_id')->unsigned()->nullable()->index();
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('no action');
            $table->integer('type_fixed_income_id')->unsigned()->nullable()->index();
            $table->foreign('type_fixed_income_id')->references('id')->on('type_fixed_incomes')->onDelete('no action');
            $table->integer('types_temporary_income_id')->unsigned()->nullable()->index();
            $table->foreign('types_temporary_income_id')->references('id')->on('types_temporary_incomes')->onDelete('no action');
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
        Schema::drop('expense_income');
    }
}
