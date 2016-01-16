<?php


use Illuminate\Database\Seeder;
use SistemasAmigables\Entities\TypeFixedIncome;

class TypeFixedIncomesTableSeeder extends Seeder {

	public function run()
	{
		
		TypeFixedIncome::create([
            'id'=>1,
            'name'=>'Diezmos',
            'balance'=>'',
            'church_id'=>1
			]);

        TypeFixedIncome::create([
            'id'=>2,
            'name'=>'Ofrenda',
            'balance'=>'',
            'church_id'=>1
			]);
        TypeFixedIncome::create([
            'id'=>3,
            'name'=>'Recoleccion',
            'balance'=>'',
            'church_id'=>1
			]);
        TypeFixedIncome::create([
            'id'=>4,
            'name'=>'Mat. Esc. Sab.',
            'balance'=>'',
            'church_id'=>1
			]);
                        
	}

}