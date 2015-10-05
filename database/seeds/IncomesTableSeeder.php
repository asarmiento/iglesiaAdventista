<?php

use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\Income;

class IncomesTableSeeder extends Seeder {

    public function run() {

        Income::create([
            'id'=>1,
            'numberOf'=>25464,
            'image'=>'',
            'date'=>'2015-01-05',
            'balance'=>'25000',
            'member_id'=>26,
            'typeFixedIncome_id'=>1,
            'record_id'=>1
        ]);
        Income::create([
            'id'=>2,
            'numberOf'=>25464,
            'image'=>'',
            'date'=>'2015-01-05',
            'balance'=>'25000',
            'member_id'=>26,
            'typeFixedIncome_id'=>2,
            'record_id'=>1
        ]);
        Income::create([
            'id'=>3,
            'numberOf'=>25464,
            'image'=>'',
            'date'=>'2015-01-05',
            'balance'=>'5000',
            'member_id'=>26,
            'typesTemporaryIncome_id'=>1,
            'record_id'=>1
        ]);
    }

}
