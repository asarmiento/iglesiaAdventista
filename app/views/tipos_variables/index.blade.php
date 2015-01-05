@extends('layouts.layouts')
@section('title')
Tipos Variables
@stop

@section('title-form')
Lista Tipos Variables
@stop

@section('content')
<div><a href="{{url()}}/tipos_variables/create"  class="button radius">Crear</a></div>
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
              @foreach($tiposvariables AS $tipoVariable)
        <tr>
    <td></td>
    <td>{{$tipoVariable->name}}</td>
    <td><a class="btn btn-warning" href="{{URL::action('TiposVariablesController@edit',$tipoVariable->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="{{URL::action('TiposVariablesController@destroy',$tipoVariable->id)}}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop