<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/02/16
 * Time: 10:23 PM
 */

Route::get('tipo-de-usuario/ver', ['as' => 'typeUser-ver', 'uses' => 'TypeUsersController@index']);
Route::get('tipo-de-usuario/create', ['as' => 'typeUser-create', 'uses' => 'TypeUsersController@create']);
Route::post('tipo-de-usuario/create', ['as' => 'typeUser-store', 'uses' => 'TypeUsersController@store']);