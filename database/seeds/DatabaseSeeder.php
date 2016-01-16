<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(TypeUsersTableSeeder::class);
        $this->call(ChurchesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TypeIncomesTableSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(MembersTableSeeder::class);
        $this->call(RecordsTableSeeder::class);
        $this->call(DepartamentsTableSeeder::class);
        $this->call(ChecksTableSeeder::class);
        $this->call(AccountCheckTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(ExpenseTableSeeder::class);
        $this->call(IncomesTableSeeder::class);

        Model::reguard();
    }
}
