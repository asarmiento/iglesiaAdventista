<?php

use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\Record;

class RecordsTableSeeder extends Seeder {

    /**
     *
     */
    public function run() {
        Record::create([
            'id' => 1,
            'numbers' => '00001',
        'controlNumber' => '2014-12-27',
            'saturday' => '2014-12-27',
            'balance' => '55000.00'
        ]);
    }

}
