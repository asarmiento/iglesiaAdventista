<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 25/04/16
 * Time: 03:45 AM
 */


Route::get('periodos',['as'=>'periodos-ver','uses'=>'PeriodsController@index']);

Route::get('saldos-periodos',['as'=>'periodos-saldos','uses'=>'PeriodsController@balance']);
Route::get('cambiar/periodo',['as'=>'periodos-create','uses'=>'PeriodsController@create']);
Route::post('cambiar/periodo',['as'=>'periodos-store','uses'=>'PeriodsController@store']);