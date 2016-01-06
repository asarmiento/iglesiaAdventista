<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 21/12/15
 * Time: 07:22 PM
 */

Route::get('cheques',['as'=>'checks-lista','uses'=>'CheckController@index']);
Route::get('cheques/create',['as'=>'checks-create','uses'=>'CheckController@create']);
Route::post('cheques/create',['as'=>'checks-save','uses'=>'CheckController@store']);
Route::get('cheques/{id}','CheckController@destroy');
