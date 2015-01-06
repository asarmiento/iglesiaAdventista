@extends('layouts.layouts')
@section('title')
Tipos de Usuario
@stop

@section('title-form')
Lista Tipos de Usuario
@stop

@section('content')
<div><a href="{{url()}}/type_users/create"  class="button radius">Crear</a></div>
<table>
    <thead>
        <tr> 
            <th width="200">Nº</th>
            <th width="150">Nombre</th> 
            <th width="150">Editar</th> 
            <th width="150">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
       @foreach($typeusers AS $typeuser)
        <tr>
    <td></td>
    <td>{{$typeuser->name}}</td>
    <td><a class="btn btn-warning" href="{{URL::action('TypeUsersController@edit',$typeuser->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="{{URL::action('TypeUsersController@destroy',$typeuser->id)}}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop