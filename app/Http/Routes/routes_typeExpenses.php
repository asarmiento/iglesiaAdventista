<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 14/01/16
 * Time: 07:42 PM
 */

Route::get('tipos-de-gastos',['as'=>'typeExp-lista','uses'=>'TypeExpensesController@index']);
Route::get('tipos-de-gastos/crear',['as'=>'crear-typeExp','uses'=>'TypeExpensesController@create']);
Route::post('tipos-de-gastos/crear',['as'=>'typeExp-crear','uses'=>'TypeExpensesController@store']);
Route::post('tipos-de-gastos/update/{id}',['as'=>'update-typeExp','uses'=>'TypeExpensesController@update']);
Route::get('tipos-de-gastos/{id}',['as'=>'typeExp-edit','uses'=>'TypeExpensesController@edit']);