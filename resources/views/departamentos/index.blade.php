@extends('layouts.layouts')
@section('title')
Departamentos
@stop

@section('title-form')
Lista Departamentos
@stop

@section('content')
<div class="btn btn-info"><a href="{{route('create-depart')}}"  class="button radius">Nuevo</a></div>
<table class="table-condensed">
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Departamento</th> 
            <th width="50">Presupuesto</th>
            <th width="50">Saldo Mes</th>
            <th width="50">Gastado</th>
        </tr>
    </thead> 
    <tbody> 
@foreach($departaments AS $key=>$departament)
        <tr>
    <td>{{$key+1}}</td>
    <td>{{$departament->name}}</td>
    </tr>
        @endforeach
    </tbody>
</table>
<div class="container">
    {!! $departaments->render()!!}
</div>
@stop