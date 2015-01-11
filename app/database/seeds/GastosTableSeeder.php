<?php

class GastosTableSeeder extends Seeder {

	public function run()
	{
		
			Gasto::create([
                            'id'=>1,
                            'num_factura'=>'25778',
                            'date'=>'2015-01-10',
                            'datefactura'=>'2015-01-05',
                            'monto'=>'5000',
                            'descripcion'=>'se compraron materiales para el departamento',
                            'departamentos_id'=>5,
                            'cheques_id'=>1
			]);
                        Gasto::create([
                            'id'=>2,
                            'num_factura'=>'67812',
                            'date'=>'2015-01-10',
                            'datefactura'=>'2015-01-05',
                            'monto'=>'15000',
                            'descripcion'=>'se reparo la pila de la clase de niños',
                            'departamentos_id'=>7,
                            'cheques_id'=>1
			]);
                        Gasto::create([
                            'id'=>3,
                            'num_factura'=>'002347',
                            'date'=>'2015-01-10',
                            'datefactura'=>'2015-01-05',
                            'monto'=>'30000',
                            'descripcion'=>'se compraron microfono de solapa',
                            'departamentos_id'=>8,
                            'cheques_id'=>1
			]);
	}

}