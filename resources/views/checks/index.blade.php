@extends('layouts.layouts')
@section('title')
Cheques
@stop

@section('title-form')
Lista Cheques
@stop

@section('content')
    <div class="btn btn-info"><a href="{{route('checks-create')}}"  class="button radius">Nuevo Cheque</a></div>
    <table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Nombre</th> 
            <th width="150">Fecha</th> 
            <th width="150">Monto</th> 
            <th width="150">Numero</th>
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody>
  @foreach($checks AS $key=>$check)
        <tr>
    <td>{{$key+1}}</td>
    <td>{{$check->name}}</td>
    <td>{{$check->date}}</td>
    <td>{{$check->amount}}</td>
    <td>{{$check->number}}</td>
    <td><a class="btn btn-warning" href="#"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="#"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop