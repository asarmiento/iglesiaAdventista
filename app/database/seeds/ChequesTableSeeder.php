<?php


class ChequesTableSeeder extends Seeder {

	public function run()
	{
		
			Cheque::create([
                            'id'=>1,
                            'numero'=>'125-6',
                            'name'=>'Anwar Sarmiento Sarmiento',
                            'date'=>'2015-01-05',
                            'detalle'=>'Reembolso de caja chicas',
                            'monto'=>'50000',
                        ]);
	}

}