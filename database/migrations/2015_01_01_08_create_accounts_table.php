<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('accounts', function(Blueprint $table) {
              $table->increments('id');
              $table->string('code');
              $table->string('name');
              $table->decimal('balance', 20, 2);
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
    Schema::drop('accounts');
}
}
