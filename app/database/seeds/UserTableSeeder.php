<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserTableSeeder extends Seeder {

    public function run() {
        DB::table('users')->delete();
        User::create(array(
            'username' => 'fierstuser',
            'password' => Hash::make('fierst_password')
        ));
        User::create(array(
            'username' => 'admin',
            'password' => Hash::make('F4cc0unt')
        ));
    }

}
