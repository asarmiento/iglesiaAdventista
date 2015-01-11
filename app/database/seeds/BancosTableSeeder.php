<?php

class BancosTableSeeder extends Seeder {

    public function run() {
        Banco::create([
            'id' => 1,
            'date' => '2015-01-05',
            'monto' => '25000',
            'historial_id' => 1
        ]);
        Banco::create([
            'id' => 2,
            'date' => '2015-01-05',
            'monto' => '25000',
            'historial_id' => 1
        ]);
        Banco::create([
            'id' => 3,
            'date' => '2015-01-05',
            'monto' => '5000',
            'historial_id' => 1
        ]);
    }

}
