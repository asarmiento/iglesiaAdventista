<?php

class IngresosTableSeeder extends Seeder {

    public function run() {

        Ingreso::create([
            'id'=>1,
            'num_sobre'=>25464,
            'num_control'=>25444,
            'date'=>'2015-01-05',
            'monto'=>'25000',
            'miembros_id'=>26,
            'tipos_fijos_id'=>1,
            'historial_id'=>1
        ]);
        Ingreso::create([
            'id'=>2,
            'num_sobre'=>25464,
            'num_control'=>25444,
            'date'=>'2015-01-05',
            'monto'=>'25000',
            'miembros_id'=>26,
            'tipos_fijos_id'=>2,
            'historial_id'=>1
        ]);
        Ingreso::create([
            'id'=>3,
            'num_sobre'=>25464,
            'num_control'=>25444,
            'date'=>'2015-01-05',
            'monto'=>'5000',
            'miembros_id'=>26,
            'tipos_variables_id'=>1,
            'historial_id'=>1
        ]);
    }

}
