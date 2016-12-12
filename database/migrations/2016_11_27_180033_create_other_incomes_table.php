<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_incomes', function(Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('voucher');
            $table->decimal('amount',20,2);
            $table->integer('type_income_id')->unsigned()->index();
            $table->foreign('type_income_id')->references('id')->on('type_incomes')->onDelete('cascade');
            $table->integer('account_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
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
        Schema::drop('other_incomes');
    }
}
