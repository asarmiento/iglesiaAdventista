<?php

class BancosTableSeeder extends Seeder {

    public function run() {
        Banco::create([
            'id' => 1,
            'date' => '2015-01-05',
            'saldo' => '25000',
            'historial_id' => 1,
            'cheques_id' => NULL,
            'tipo'=>'entradas'
        ]);
        Banco::create([
            'id' => 2,
            'date' => '2015-01-05',
            'saldo' => '25000',
            'historial_id' => 1,
            'cheques_id' => NULL,
            'tipo'=>'entradas'
        ]);
        Banco::create([
            'id' => 3,
            'date' => '2015-01-05',
            'saldo' => '5000',
            'historial_id' => 1,
            'cheques_id' => NULL,
            'tipo'=>'entradas'
        ]);
        Banco::create([
            'id' => 4,
            'date' => '2015-01-05',
            'saldo' => '50000',
            'historial_id' => NULL,
            'cheques_id' => 1,
            'tipo'=>'salidas'
        ]);
    }

}
