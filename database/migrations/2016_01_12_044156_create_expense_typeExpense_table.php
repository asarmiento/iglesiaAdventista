<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTypeExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_typeExpense', function(Blueprint $table) {
            $table->increments('id');
            $table->decimal('balance', 20, 2);
            $table->integer('expense_id')->unsigned()->nullable()->index();
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('no action');
            $table->integer('type_expense_id')->unsigned()->nullable()->index();
            $table->foreign('type_expense_id')->references('id')->on('type_expenses')->onDelete('no action');
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
        Schema::drop('expense_typeExpense');
    }
}
