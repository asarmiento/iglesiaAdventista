<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 05/01/16
 * Time: 05:39 PM
 */



Route::get('gastos/create/{id}',['as'=>'create-gasto','uses'=>'ExpenseController@create']);
Route::get('gastos',['as'=>'index-gasto','uses'=>'ExpenseController@index']);
Route::get('gastos/edit/{token}',['as'=>'editar-gasto','uses'=>'ExpenseController@showInforme']);
Route::post('gastos/create',['as'=>'gasto-store','uses'=>'ExpenseController@store']);