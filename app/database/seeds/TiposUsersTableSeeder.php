<?php

class TiposUsersTableSeeder extends Seeder {

	public function run()
	{
		
			TiposUser::create([
                            'id'=>1,
                            'name'=>'Administrador'
			]);
                        TiposUser::create([
                            'id'=>2,
                            'name'=>'Tesoreros'
			]);
                        TiposUser::create([
                            'id'=>3,
                            'name'=>'Observador'
			]);
	}

}