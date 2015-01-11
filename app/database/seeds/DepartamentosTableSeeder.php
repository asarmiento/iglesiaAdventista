<?php


class DepartamentosTableSeeder extends Seeder {

	public function run()
	{
	
			Departamento::create([
                            'id'=>1,
                            'name'=>'Escuela Sabática',
                            'saldo'=>'20000',
                            'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>2,
                            'name'=>'Diaconisas',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>3,
                            'name'=>'Ministerio Personales',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>4,
                            'name'=>'Dorcas',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>5,
                            'name'=>'Ministerio de la Familia',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>6,
                            'name'=>'Ministerio de la Mujer',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>7,
                            'name'=>'Ministerio Infatil',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>8,
                            'name'=>'Sociedad de Jovenes',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>9,
                            'name'=>'Club de Guias Mayores',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>10,
                            'name'=>'Club de Aventureros',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>11,
                            'name'=>'Club de Conquistadores',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>12,
                            'name'=>'Mayordomia',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>13,
                            'name'=>'Comunicaciones',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'id'=>14,
                            'name'=>'Libertad Religiosa',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
	}

}