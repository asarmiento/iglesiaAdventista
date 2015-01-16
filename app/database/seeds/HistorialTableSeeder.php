<?php

class HistorialTableSeeder extends Seeder {

    public function run() {
        Historial::create([
            'id' => 1,
            'numero' => '00001',
            'sabado' => '2014-12-27',
            'saldo' => '55000.00'
        ]);
    }

}
