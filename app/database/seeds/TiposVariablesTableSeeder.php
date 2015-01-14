<?php

class TiposVariablesTableSeeder extends Seeder {

    public function run() {

        TiposVariable::create([
            'id' => 1,
            'name' => 'Bancas',
            'saldo' => '0.00',
            'iglesias_id' => 1
        ]);
    }

}
