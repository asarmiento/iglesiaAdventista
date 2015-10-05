<?php


use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\Check;

class ChecksTableSeeder extends Seeder {

	public function run()
	{
		
			Check::create([
                            'id'=>1,
                            'number'=>'125-6',
                            'name'=>'Anwar Sarmiento Sarmiento',
                            'date'=>'2015-01-05',
                            'detail'=>'Reembolso de caja chicas',
                            'amount'=>'50000',
                            'church_id'=>1,
                        ]);
	}

}