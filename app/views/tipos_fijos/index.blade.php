@extends('layouts.layouts')
@section('title')
Tipos Fijos
@stop

@section('title-form')
Lista Tipos Fijos
@stop

@section('content')
<div><a href="{{url()}}/tipos_fijos/create"  class="button radius">Crear</a></div>
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
          @foreach($tiposfijos AS $tipoFijo)
        <tr>
    <td></td>
    <td>{{$tipoFijo->name}}</td>
    <td><a class="btn btn-warning" href="{{URL::action('TiposFijosController@edit',$tipoFijo->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="{{URL::action('TiposFijosController@destroy',$tipoFijo->id)}}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop