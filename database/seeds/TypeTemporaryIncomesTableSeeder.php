<?php

use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\TypesTemporaryIncome;

class TypeTemporaryIncomesTableSeeder extends Seeder {

    public function run() {

        TypesTemporaryIncome::create([
            'id' => 1,
            'name' => 'Bancas',
            'balance' => '0.00',
            'church_id' => 1
        ]);
    }

}
