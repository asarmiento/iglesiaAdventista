<?php


class DepartamentosTableSeeder extends Seeder {

	public function run()
	{
	
			Departamento::create([
                            'name'=>'Escuela Sabática',
                            'saldo'=>'20000',
                            'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Diaconisas',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Ministerio Personales',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Dorcas',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Ministerio de la Familia',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Ministerio de la Mujer',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Ministerio Infatil',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Sociedad de Jovenes',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Club de Guias Mayores',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Club de Aventureros',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Club de Conquistadores',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Mayordomia',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Comunicaciones',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
                        Departamento::create([
                            'name'=>'Libertad Religiosa',
                            'saldo'=>'20000',
			    'iglesias_id'=>1
			]);
	}

}