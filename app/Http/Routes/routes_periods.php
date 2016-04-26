<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 25/04/16
 * Time: 03:45 AM
 */


Route::get('periodos',['as'=>'periodos-ver','uses'=>'PeriodsController@index']);
Route::get('cambiar/periodo',['as'=>'periodos-create','uses'=>'PeriodsController@create']);