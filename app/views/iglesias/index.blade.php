@extends('layouts.layouts')
@section('title')
Iglesias
@stop

@section('title-form')
Lista Iglesias
@stop
@section('content')
<div><a href="{{url()}}/iglesias/create"  class="button radius">Crear</a></div>
<table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Nombre</th> 
            <th width="150">Dirección</th> 
            <th width="150">Editar</th> 
            <th width="150">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
        @foreach($iglesias AS $iglesia)
        <tr>
    <td></td>
    <td>{{$iglesia->name}}</td>
    <td>{{$iglesia->address}}</td>
    <td><a class="btn btn-warning" href="{{URL::action('IglesiasController@edit',$iglesia->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="{{URL::action('IglesiasController@destroy',$iglesia->id)}}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop