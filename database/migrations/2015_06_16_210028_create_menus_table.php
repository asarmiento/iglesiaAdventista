<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
	Schema::create('menus', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name',80)->unique();
            $table->string('url',150)->unique();
            $table->string('icon_font', 50);
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
	public function down()
	{
		Schema::drop('menus');
	}
}
