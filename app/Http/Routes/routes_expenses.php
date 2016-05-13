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
Route::get('gastos/ver/{token}',['as'=>'ver-gasto','uses'=>'ExpenseController@show']);
Route::get('gastos/delete/{id}',['as'=>'delete-gasto','uses'=>'ExpenseController@deleteExpense']);
Route::post('gastos/create',['as'=>'gasto-store','uses'=>'ExpenseController@store']);
Route::get('gastos/traspaso-de-fondos/ver',['as'=>'index-transfer','uses'=>'ExpenseController@transfer']);
Route::get('gastos/traspaso-de-fondos/create',['as'=>'ddd-store','uses'=>'ExpenseController@trapaso']);
Route::post('gastos/traspaso-de-fondos/create',['as'=>'traspaso-store','uses'=>'ExpenseController@trapasoStore']);
Route::get('ver-historial/gastos',['as'=>'lista-gastos','uses'=>'ExpenseController@viewInd']);
Route::post('ver-historial/gastos',['as'=>'lista-gastos-pdf','uses'=>'Report\InformeExpenses@index']);