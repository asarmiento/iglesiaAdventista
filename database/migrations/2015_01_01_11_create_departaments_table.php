<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartamentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departaments', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type_budget',['percentage','fixed']);
            $table->decimal('budget', 20, 2);
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
        Schema::drop('departaments');
    }

}
