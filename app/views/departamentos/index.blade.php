@extends('layouts.layouts')
@section('title')
Departamentos
@stop

@section('title-form')
Lista Departamentos
@stop

@section('content')
<div><a href="{{url()}}/departamentos/create"  class="button radius">Crear</a></div>
<table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Departamento</th> 
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
@foreach($departamentos AS $departamento)
        <tr>
    <td></td>
    <td>{{$departamento->name}}</td>
    <td><a class="btn btn-warning" href="{{URL::action('DepartamentosController@edit',$departamento->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="{{URL::action('DepartamentosController@destroy',$departamento->id)}}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
<div class="container">
    {{$departamentos->links()}}
</div>
@stop