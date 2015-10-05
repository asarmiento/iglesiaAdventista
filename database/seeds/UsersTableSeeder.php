<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Seeder;
/**
 * Description of UsersTableSeeder
 *
 * @author Anwar Sarmiento
 */
class UsersTableSeeder  extends Seeder{
    //put your code here
    public function run() {
        \DB::table('users')->insert([
            'id' => 1,
            'name' => 'Francisco',
            'last' => 'Gamonal',
            'email' => 'hfgamonalb@gmail.com',
            'password' => \Hash::make('123456'),
            'typeUser_id' => 1,
            'token' => 'dds42rwsfw32ddsaf2r3qcd1321312312b56'
         ]);

        \DB::table('users')->insert([
            'id' => 2,
            'name' => 'Anwar',
            'last' => 'Sarmiento',
            'email' => 'anwarsarmiento@gmail.com',
            'password' => \Hash::make('F4cc0unt'),
            'typeUser_id' => 1,
            'token' => 'dds42rwsfw32ddsaf2r3qcd1b56eqw233ewq'
         ]);

        \DB::table('users')->insert([
            'id' => 3,
            'name' => 'Jair',
            'last' => '',
            'email' => 'jgt08@hotmail.com',
            'password' => Hash::make('jair'),
            'typeUser_id' => 1,
            'token' => 'dds42rwsfw32ddscaf2r3qcasdd13213r2rawrara312312rrw'
         ]);
    }
}
