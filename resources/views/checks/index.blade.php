@extends('layouts.layouts')
@section('title')
Cheques
@stop

@section('title-form')
Lista Cheques
@stop

@section('content')
<table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Nombre</th> 
            <th width="150">Fecha</th> 
            <th width="150">Monto</th> 
            <th width="150">Departamento</th> 
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody>
  @foreach($checks AS $check)
        <tr>
    <td></td>
    <td>{{$check->name}}</td>
    <td>{{$check->date}}</td>
    <td>{{$check->monto}}</td>
    <td></td>
    <td><a class="btn btn-warning" href="#"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="#"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop