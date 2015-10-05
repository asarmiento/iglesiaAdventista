<?php


use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\Church;

class ChurchesTableSeeder extends Seeder {

	public function run()
	{
		Church::create([
                    'id'=>1,
                    'name'=>'Iglesia Quepos'
			]);
		
	}

}