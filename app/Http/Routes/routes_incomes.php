<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/12/15
 * Time: 02:38 PM
 */

Route::get('sobres-diezmos/{token}',['as'=>'create-income','uses'=>'IncomeController@create']);
Route::get('lista-detalle/sobres-diezmos',['as'=>'index-income','uses'=>'IncomeController@index']);
Route::post('sobres-diezmos',['as'=>'incomes-store','uses'=>'IncomeController@store']);