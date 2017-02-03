<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 04/05/16
 * Time: 08:46 PM
 */

Route::get('reporte-mensual/{token}',['as'=>'informe-mensual-period','uses'=>'ChurchController@report']);
Route::get('reporte-auditoria',['as'=>'auditoria-ver','uses'=>'ChurchController@auditoria']);
Route::post('reporte-auditoria',['as'=>'pdf-auditoria','uses'=>'ChurchController@pdfAuditoria']);
