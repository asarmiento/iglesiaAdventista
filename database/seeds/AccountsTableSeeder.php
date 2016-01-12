<?php


use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\Account;
use SistemasAmigables\Entities\Check;

class AccountsTableSeeder extends Seeder {

	public function run()
	{
		
			Account::create([
                            'id'=>1,
                            'code'=>'200-01-022-003599-0',
                            'name'=>'Banco Nacional',
                            'balance'=>'527000'
                        ]);

		Account::create([
			'id'=>2,
			'code'=>'245-0000',
			'name'=>'Banco de Costa Rica',
			'balance'=>'527000'
		]);
	}

}