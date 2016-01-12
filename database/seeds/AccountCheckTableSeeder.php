<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SistemasAmigables\Entities\Account;
use SistemasAmigables\Entities\Check;

class AccountCheckTableSeeder extends Seeder {

	public function run()
	{

		DB::table('account_check')->insert([
                            'id'=>1,
                            'check_id'=>1,
                            'account_id'=>1,
                            'balance'=>'527000'
                        ]);

		DB::table('account_check')->insert([
			'id'=>2,
			'check_id'=>1,
			'account_id'=>2,
			'balance'=>'527000'
		]);
	}

}