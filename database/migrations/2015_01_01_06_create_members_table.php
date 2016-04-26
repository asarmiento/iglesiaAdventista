<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('members', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 80);
            $table->string('last', 80);
            $table->string('charter', 80);
            $table->date('bautizmoDate');
            $table->date('birthdate');
            $table->string('phone', 10);
            $table->string('cell', 10);
            $table->string('email');
            $table->string('token');
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
        Schema::drop('members');
    }

}
