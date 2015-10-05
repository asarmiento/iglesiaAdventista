<?php

use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\Expense;

class ExpenseTableSeeder extends Seeder {

	public function run()
	{
		
			Expense::create([
                            'id'=>1,
                            'invoiceNumber'=>'25778',
                            'date'=>'2015-01-10',
                            'invoiceDate'=>'2015-01-05',
                            'amount'=>'5000',
                            'detail'=>'se compraron materiales para el departamento',
                            'departament_id'=>5,
                            'check_id'=>1
			]);
        Expense::create([
                            'id'=>2,
                            'invoiceNumber'=>'67812',
                            'date'=>'2015-01-10',
                            'invoiceDate'=>'2015-01-05',
                            'amount'=>'15000',
                            'detail'=>'se reparo la pila de la clase de niños',
                            'departament_id'=>7,
                            'check_id'=>1
			]);
        Expense::create([
                            'id'=>3,
                            'invoiceNumber'=>'002347',
                            'date'=>'2015-01-10',
                            'invoiceDate'=>'2015-01-05',
                            'amount'=>'30000',
                            'detail'=>'se compraron microfono de solapa',
                            'departament_id'=>8,
                            'check_id'=>1
			]);
	}

}