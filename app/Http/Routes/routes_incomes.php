<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/12/15
 * Time: 02:38 PM
 */

Route::get('sobres-de-diezmos/{token}',['as'=>'create-income','uses'=>'IncomeController@create']);
Route::get('informe-mensual',['as'=>'info-income','uses'=>'ReportController@informe']);
Route::get('lista-detalle/sobres-diezmos',['as'=>'index-income','uses'=>'IncomeController@index']);
Route::get('informe-semanal/lista-detalle/{token}',['as'=>'informe-semanal','uses'=>'IncomeController@showInforme']);
Route::post('save-informe',['as'=>'incomes-store','uses'=>'IncomeController@store']);