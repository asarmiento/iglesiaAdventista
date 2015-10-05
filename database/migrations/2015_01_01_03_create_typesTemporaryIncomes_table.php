<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTypesTemporaryIncomesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('types_temporary_incomes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('balance', 20, 2);
            $table->integer('church_id')->unsigned()->index();
             $table->foreign('church_id')->references('id')->on('churches')->onDelete('no action');
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
        Schema::drop('types_temporary_incomes');
    }

}
