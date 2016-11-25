<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 22/12/15
 * Time: 09:38 PM
 */

Route::get('tipos-de-ingresos',['as'=>'typeFix-lista','uses'=>'TypeIncomeController@index']);
Route::get('tipos-de-ingresos/crear',['as'=>'crear-typeFix','uses'=>'TypeIncomeController@create']);
Route::get('tipos-de-ingresos/relacionar',['as'=>'realacionar-typeFix','uses'=>'TypeIncomeController@relation']);
Route::post('tipos-de-ingresos/relacionar',['as'=>'relation-save','uses'=>'TypeIncomeController@relationSave']);
Route::post('tipos-de-ingresos/crear',['as'=>'crear-typeFixs','uses'=>'TypeIncomeController@store']);
Route::post('tipos-de-ingresos/update/{id}',['as'=>'update-typeFixs','uses'=>'TypeIncomeController@update']);
Route::get('tipos-de-ingresos/{id}',['as'=>'typeFix-edit','uses'=>'TypeIncomeController@edit']);
Route::get('tipos-de-ingresos/activar/{id}',['as'=>'activar-tipo-ingreso','uses'=>'TypeIncomeController@active']);
Route::get('tipos-de-ingresos/desactivar/{id}',['as'=>'desactivar-tipo-ingreso','uses'=>'TypeIncomeController@desactive']);