@extends('layouts.layouts')
@section('title')
Miembros
@stop

@section('title-form')
Lista Miembros
@stop

@section('content')
<div><a href="{{url()}}/miembros/create"  class="button radius">Agregar</a></div>
<table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="250">Nombre</th> 
            <th width="150">Telefono</th> 
            <th width="150">Celular</th> 
            <th width="150">Email</th> 
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
         @foreach($miembros AS $miembro)
        <tr>
    <td></td>
    <td>{{$miembro->name}} {{$miembro->last}}</td>
    <td>{{$miembro->phone}}</td>
    <td>{{$miembro->celular}}</td>
    <td>{{$miembro->email}}</td>
    <td><a class="btn btn-warning" href="{{URL::action('MiembrosController@edit',$miembro->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="{{URL::action('MiembrosController@destroy',$miembro->id)}}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop