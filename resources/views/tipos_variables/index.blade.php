@extends('layouts.layouts')
@section('title')
Tipos Variables
@stop

@section('title-form')
Lista Tipos Variables
@stop

@section('content')
<div class="btn btn-info"><a href="{{route('crear-variableType')}}"  class="button radius">Nuevo</a></div>
<table>
    <thead>
        <tr> 
            <th width="200">Nº</th>
            <th width="150">Nombre</th> 
            <th width="150">Ingresos</th>
            <th width="150">Editar</th>
        </tr>
    </thead> 
    <tbody> 
              @foreach($tiposvariables AS $key=>$tipoVariable)
        <tr>
    <td>{{$key+1}}</td>
    <td>{{$tipoVariable->name}}</td>
    <td>{{number_format($tipoVariable->balance,2)}}</td>
    <td><a class="btn btn-warning" href="{{route('variableType-edit',$tipoVariable->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop