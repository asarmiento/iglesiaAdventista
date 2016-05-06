<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 04/05/16
 * Time: 08:46 PM
 */

Route::get('reporte-mensual/{token}',['as'=>'informe-mensual','uses'=>'ChurchController@report']);
