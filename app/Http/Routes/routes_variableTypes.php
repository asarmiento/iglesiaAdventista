<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 22/12/15
 * Time: 10:29 PM
 */


Route::get('tipos-variables',['as'=>'variableType-lista','uses'=>'TypesTemporaryIncomeController@index']);
Route::get('tipos-variables/crear',['as'=>'crear-variableType','uses'=>'TypesTemporaryIncomeController@create']);
Route::post('tipos-variables/crear',['as'=>'crear-variableTypes','uses'=>'TypesTemporaryIncomeController@store']);
Route::get('tipos-variables/{id}',['as'=>'variableType-edit','uses'=>'TypesTemporaryIncomeController@edit']);