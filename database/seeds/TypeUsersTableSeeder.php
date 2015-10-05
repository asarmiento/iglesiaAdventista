<?php

use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\TypeUser;

class TypeUsersTableSeeder extends Seeder {

	public function run()
	{

        TypeUser::create([
                            'id'=>1,
                            'name'=>'Administrador'
			]);
        TypeUser::create([
                            'id'=>2,
                            'name'=>'Tesoreros'
			]);
        TypeUser::create([
                            'id'=>3,
                            'name'=>'Observador'
			]);
	}

}