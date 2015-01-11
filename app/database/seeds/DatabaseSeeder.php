<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Eloquent::unguard();
        
        $this->call('TiposFijosTableSeeder');
        $this->call('TiposVariablesTableSeeder');
        $this->call('TiposUsersTableSeeder');
        $this->call('IglesiasTableSeeder');
        $this->call('MiembrosTableSeeder');
        $this->call('HistorialTableSeeder');
        $this->call('DepartamentosTableSeeder');
        $this->call('IngresosTableSeeder');
        $this->call('ChequesTableSeeder');
        $this->call('BancosTableSeeder');
        $this->call('GastosTableSeeder');
    }

}
