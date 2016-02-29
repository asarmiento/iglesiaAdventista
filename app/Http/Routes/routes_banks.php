<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/02/16
 * Time: 07:59 PM
 */
Route::get('bancos/ver', ['as' => 'bank-ver', 'uses' => 'BankController@index']);
Route::get('bancos/create', ['as' => 'bank-create', 'uses' => 'BankController@create']);
Route::get('bancos/depositos/ver', ['as' => 'deposito-ver', 'uses' => 'BankController@deposit']);
Route::get('bancos/depositos/create', ['as' => 'create-deposit', 'uses' => 'BankController@depositCreate']);
Route::post('bancos/depositos/create', ['as' => 'post-deposit', 'uses' => 'BankController@depositStore']);
Route::post('bancos/create', ['as' => 'bank-store', 'uses' => 'BankController@store']);