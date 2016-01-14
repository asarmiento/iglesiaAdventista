<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 22/12/15
 * Time: 09:38 PM
 */

Route::get('tipos-fijos',['as'=>'typeFix-lista','uses'=>'TypeFixedIncomeController@index']);
Route::get('tipos-fijos/crear',['as'=>'crear-typeFix','uses'=>'TypeFixedIncomeController@create']);
Route::post('tipos-fijos/crear',['as'=>'crear-typeFixs','uses'=>'TypeFixedIncomeController@store']);
Route::post('tipos-fijos/update/{id}',['as'=>'update-typeFixs','uses'=>'TypeFixedIncomeController@update']);
Route::get('tipos-fijos/{id}',['as'=>'typeFix-edit','uses'=>'TypeFixedIncomeController@edit']);