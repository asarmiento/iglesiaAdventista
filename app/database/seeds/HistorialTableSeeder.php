<?php

class HistorialTableSeeder extends Seeder {

    public function run() {
        Historial::create([
            'id' => 1,
            'sabado' => '2014-12-27'
        ]);
    }

}
