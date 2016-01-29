<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 21/12/15
 * Time: 09:04 PM
 */
Route::get('informes',['as'=>'index-record','uses'=>'RecordsController@index']);
Route::post('informes/create',array('as'=>'save-record','uses'=>'RecordsController@store'));
Route::get('informes/create',array('as'=>'create-record','uses'=>'RecordsController@create'));


