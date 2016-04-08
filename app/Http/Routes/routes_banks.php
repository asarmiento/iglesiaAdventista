<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/02/16
 * Time: 07:59 PM
 */
Route::get('bancos/ver', ['as' => 'bank-ver', 'uses' => 'BankController@index']);
Route::get('bancos/create', ['as' => 'bank-create', 'uses' => 'BankController@create']);
Route::post('bancos/create', ['as' => 'bank-store', 'uses' => 'BankController@store']);


Route::get('bancos/depositos/ver', ['as' => 'deposito-ver', 'uses' => 'BankController@deposit']);
Route::get('bancos/depositos/create', ['as' => 'create-deposit', 'uses' => 'BankController@depositCreate']);
Route::post('bancos/depositos/create', ['as' => 'post-deposit', 'uses' => 'BankController@depositStore']);


Route::get('bancos/depositos-campo-loca/ver', ['as' => 'deposito-campo-ver', 'uses' => 'BankController@depositCampo']);
Route::get('bancos/depositos-campo-loca/create', ['as' => 'create-deposit-campo', 'uses' => 'BankController@depositCampoCreate']);
Route::post('bancos/depositos-campo-loca/create', ['as' => 'store-deposit-campo', 'uses' => 'BankController@depositCampoStore']);


Route::get('campo-loca/ver', ['as' => 'campo-ver', 'uses' => 'Report\InformesComparativo@index']);
Route::get('estado-de-cuenta/{id}', ['as' => 'estado-de-cuenta-ver', 'uses' => 'BankController@estasoCuenta']);
Route::post('estado-de-cuenta', ['as' => 'estado-de-cuenta', 'uses' => 'Report\EstadoDeCuenta@index']);
Route::get('deposito-informes/{year}', ['as' => 'dep-Ingresos', 'uses' => 'Report\EstadoDeCuenta@depositos']);
Route::post('campo-loca/report', ['as' => 'report-campo', 'uses' => 'Report\InformesComparativo@report']);
