<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 21/12/15
 * Time: 07:18 PM
 */

Route::get('miembros',['as'=>'members-lista','uses'=>'MemberController@index']);
Route::get('miembros/crear',['as'=>'crear-miembro','uses'=>'MemberController@create']);
Route::post('miembros/crear',['as'=>'crear-members','uses'=>'MemberController@store']);
Route::get('miembros/{id}',['as'=>'member-edit','uses'=>'MemberController@edit']);
Route::get('miembros/ver/{token}','MemberController@view');
