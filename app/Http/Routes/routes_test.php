<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 10/01/16
 * Time: 01:54 PM
 */

Route::get('test', 'TestController@show');
Route::get('test/token', 'TestController@token');
Route::get('test/traslado', 'TestController@trasladoExpense');