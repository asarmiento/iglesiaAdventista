<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/12/15
 * Time: 07:31 PM
 */

Route::get('departamentos/crear',['as'=>'create-depart','uses'=>'DepartamentsController@create']);
Route::get('departamentos',['as'=>'index-depart','uses'=>'DepartamentsController@index']);
Route::post('departamentos/crear',['as'=>'depart-store','uses'=>'DepartamentsController@store']);

