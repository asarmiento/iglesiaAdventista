<?php


use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\Departament;

class DepartamentsTableSeeder extends Seeder {

	public function run()
	{
	
			Departament::create([
                            'id'=>1,
                            'name'=>'Escuela Sabática',
                            'balance'=>'20000',
                            'church_id'=>1
			]);
                        Departament::create([
                            'id'=>2,
                            'name'=>'Diaconisas',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>3,
                            'name'=>'Ministerio Personales',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>4,
                            'name'=>'Dorcas',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>5,
                            'name'=>'Ministerio de la Familia',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>6,
                            'name'=>'Ministerio de la Mujer',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>7,
                            'name'=>'Ministerio Infatil',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>8,
                            'name'=>'Sociedad de Jovenes',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>9,
                            'name'=>'Club de Guias Mayores',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>10,
                            'name'=>'Club de Aventureros',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>11,
                            'name'=>'Club de Conquistadores',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>12,
                            'name'=>'Mayordomia',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>13,
                            'name'=>'Comunicaciones',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
                        Departament::create([
                            'id'=>14,
                            'name'=>'Libertad Religiosa',
                            'balance'=>'20000',
			    'church_id'=>1
			]);
	}

}