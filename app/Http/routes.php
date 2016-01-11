<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return redirect()->route('auth/login');
});

/* Log */
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

// Authentication routes.
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' => 'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);


Route::resource('expenses','ExpenseController');


Route::group(['prefix' => 'iglesia'], function () {

	Route::resource('iglesias','ChurchController');
	/* Test para hacer pruebas */
	Route::get('reportes/fondos', ['as' => 'fondos-report', 'uses' => 'ReportController@index']);
	Route::post('reportes/fondos', ['as' => 'post-report', 'uses' => 'ReportController@store']);
		$routes = ['members','checks','record','typeFix','variableTypes','incomes',
			'departaments','expenses','test'];
		/*
        * Rutas de Bancos
        */
		foreach($routes AS $route):
			require __DIR__.'/Routes/routes_'.$route.'.php';
		endforeach;
});


Route::resource('type_users','TypeUsersController');

Route::resource('users','UsersController');
//restores
Route::put('type_users/restore/{id}',array('as' => 'restore_tuser', 'uses' => 'TypeUsersController@restore'));
Route::put('iglesias/restore/{id}',array('as' => 'restore_iglesia', 'uses' => 'ChurchController@restore'));
//test

//Route::get('vista/{$variable}', array('as' => 'vista',    'uses' => 'vistaController@vista'));