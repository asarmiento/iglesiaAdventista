<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::resource('cheques','ChequesController');
Route::resource('gastos','GastosController');
Route::resource('iglesias','IglesiasController');
Route::resource('ingresos','IngresosController');
Route::resource('departamentos','DepartamentosController');
Route::resource('miembros','MiembrosController');
Route::resource('tipos_fijos','TiposFijosController');
Route::resource('tipos_variables','TiposVariablesController');
Route::resource('type_users','TypeUsersController');
Route::resource('informes','HistorialController');
Route::resource('users','UsersController');
//restores
Route::put('type_users/restore/{id}',array('as' => 'restore_tuser', 'uses' => 'TypeUsersController@restore'));
Route::put('iglesias/restore/{id}',array('as' => 'restore_iglesia', 'uses' => 'IglesiasController@restore'));
//test
Route::get('test', 'TestController@show');
