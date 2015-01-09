<?php



class TiposFijosTableSeeder extends Seeder {

	public function run()
	{
		
			TiposFijo::create([
                            'id'=>1,
                            'name'=>'Diezmos'
			]);
                        
                        TiposFijo::create([
                            'id'=>2,
                            'name'=>'Ofrenda'
			]);
                        TiposFijo::create([
                            'id'=>3,
                            'name'=>'Recoleccion'
			]);
                        TiposFijo::create([
                            'id'=>4,
                            'name'=>'Mat. Esc. Sab.'
			]);
                        
	}

}