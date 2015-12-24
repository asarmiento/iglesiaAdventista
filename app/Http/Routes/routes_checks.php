<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 21/12/15
 * Time: 07:22 PM
 */

Route::get('cheques',['as'=>'checks-lista','uses'=>'CheckController@index']);
Route::get('cheques/{id}',['as'=>'checks-edit','uses'=>'CheckController@edit']);
Route::get('cheques/{id}','CheckController@destroy');
Route::resource('checks','CheckController');