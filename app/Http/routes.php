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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

/* Log */
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('cheques',['as'=>'checks-lista','uses'=>'CheckController@index']);
Route::get('cheques/{id}',['as'=>'checks-edit','uses'=>'CheckController@edit']);
Route::get('cheques/{id}','CheckController@destroy');
Route::resource('checks','CheckController');
Route::resource('gastos','ExpenseController');
Route::resource('iglesias','ChurchController');

Route::get('sobres-diezmos/{token}',array('as'=>'create-income','uses'=>'IncomeController@create'));
Route::post('sobres-diezmos',array('as'=>'incomes-store','uses'=>'IncomeController@store'));

Route::resource('departamentos','DepartamentsController');

Route::get('miembros',['as'=>'members-lista','uses'=>'MemberController@index']);
Route::get('miembros/crear',['as'=>'crear-miembro','uses'=>'MemberController@create']);
Route::post('miembros/crear',['as'=>'crear-members','uses'=>'MemberController@store']);
Route::get('miembros/{id}',['as'=>'member-edit','uses'=>'MemberController@edit']);
Route::get('miembros/{id}','MemberController@destroy');
Route::resource('miembros','MemberController');


Route::resource('tipos_fijos','TypeFixedIncomeController');
Route::resource('tipos_variables','TypesTemporaryIncomeController');
Route::resource('type_users','TypeUsersController');


Route::post('informes/create',array('as'=>'save-record','uses'=>'RecordsController@store'));
Route::get('informes/create',array('as'=>'create-record','uses'=>'RecordsController@create'));
Route::get('/informes','RecordsController@index');




Route::resource('users','UsersController');
//restores
Route::put('type_users/restore/{id}',array('as' => 'restore_tuser', 'uses' => 'TypeUsersController@restore'));
Route::put('iglesias/restore/{id}',array('as' => 'restore_iglesia', 'uses' => 'ChurchController@restore'));
//test
Route::get('test', 'TestController@show');
//Route::get('vista/{$variable}', array('as' => 'vista',    'uses' => 'vistaController@vista'));