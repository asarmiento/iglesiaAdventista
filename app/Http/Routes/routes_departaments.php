<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/12/15
 * Time: 07:31 PM
 */

Route::get('departamentos/crear',['as'=>'create-depart','uses'=>'DepartamentsController@create']);
Route::get('departamentos',['as'=>'index-depart','uses'=>'DepartamentsController@index']);
Route::get('departamentos/movimientos',['as'=>'date-depart','uses'=>'DepartamentsController@moveDepartament']);
Route::post('departamentos/movimientos',['as'=>'date-post-depart','uses'=>'DepartamentsController@storeDepartament']);
Route::post('departamentos/crear',['as'=>'depart-store','uses'=>'DepartamentsController@store']);

