<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		 $this->call('IglesiasTableSeeder');
                 $this->call('MiembrosTableSeeder');
                 $this->call('TiposFijosTableSeeder');
                 $this->call('TiposVariablesTableSeeder');
                 $this->call('TipoUsersTableSeeder');
	}

}
