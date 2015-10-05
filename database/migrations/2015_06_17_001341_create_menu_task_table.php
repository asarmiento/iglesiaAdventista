<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
	Schema::create('menu_task', function(Blueprint $table) {
        $table->integer('task_id')->unsigned()->index();
        $table->foreign('task_id')->references('id')->on('tasks')->onDelete('no action');
        $table->integer('menu_id')->unsigned()->index();
        $table->foreign('menu_id')->references('id')->on('menus')->onDelete('no action');
        $table->boolean('status');
        $table->engine = 'InnoDB';
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menu_task');
	}
}
