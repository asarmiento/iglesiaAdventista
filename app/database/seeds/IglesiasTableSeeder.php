<?php


class IglesiasTableSeeder extends Seeder {

	public function run()
	{
		Iglesia::create([
                    'id'=>1,
                    'name'=>'Iglesia Quepos'
			]);
		
	}

}