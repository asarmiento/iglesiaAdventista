<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/12/15
 * Time: 02:38 PM
 */

Route::get('sobres-de-diezmos/{token}',['as'=>'create-income','uses'=>'IncomeController@create']);
Route::get('informe-mensual/ver',['as'=>'info-income','uses'=>'IncomeController@estadoCuenta']);
Route::get('informe-mensual',['as'=>'informe-Mensual','uses'=>'ReportController@informe']);
Route::get('lista-detalle/sobres-diezmos',['as'=>'index-income','uses'=>'IncomeController@index']);
Route::get('informe-semanal/lista-detalle/{token}',['as'=>'informe-semanal','uses'=>'IncomeController@showInforme']);
Route::post('save-informe',['as'=>'incomes-store','uses'=>'IncomeController@store']);
Route::get('enviar-campo-local/{token}',['as'=>'send-income','uses'=>'IncomeController@send']);