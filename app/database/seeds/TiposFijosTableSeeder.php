<?php



class TiposFijosTableSeeder extends Seeder {

	public function run()
	{
		
			TiposFijo::create([
                            'id'=>1,
                            'name'=>'Diezmos',
                            'iglesias_id'=>1
			]);
                        
                        TiposFijo::create([
                            'id'=>2,
                            'name'=>'Ofrenda',
                            'iglesias_id'=>1
			]);
                        TiposFijo::create([
                            'id'=>3,
                            'name'=>'Recoleccion',
                            'iglesias_id'=>1
			]);
                        TiposFijo::create([
                            'id'=>4,
                            'name'=>'Mat. Esc. Sab.',
                            'iglesias_id'=>1
			]);
                        
	}

}