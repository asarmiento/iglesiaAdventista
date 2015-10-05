<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIncomesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('incomes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('numberOf');
            $table->integer('url');
            $table->date('image');
            $table->date('date');
            $table->decimal('balance', 20, 2);
            $table->integer('record_id')->unsigned()->index();
            $table->foreign('record_id')->references('id')->on('records')->onDelete('no action');
            $table->integer('member_id')->unsigned()->index();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('no action');
            $table->integer('typeFixedIncome_id')->unsigned()->nullable()->index();
            $table->foreign('typeFixedIncome_id')->references('id')->on('type_fixed_incomes')->onDelete('no action');
            $table->integer('typesTemporaryIncome_id')->unsigned()->nullable()->index();
            $table->foreign('typesTemporaryIncome_id')->references('id')->on('types_temporary_incomes')->onDelete('no action');
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
        Schema::drop('incomes');
    }

}
