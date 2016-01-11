@extends('layouts.layouts')
@section('title')
Departamentos
@stop

@section('title-form')
Lista Departamentos
@stop

@section('content')
<div class="btn btn-info"><a href="{{route('create-depart')}}"  class="button radius">Nuevo</a></div>
<div class="panel-body">
<table id="table_depart" class="table-condensed">
    <thead>
        <tr> 
            <th>Nº</th>
            <th>Departamento</th>
            <th>Presupuesto</th>
            <th>Saldo Mes</th>
            <th>Gastado</th>
        </tr>
    </thead> 
    <tbody> 
@foreach($departaments AS $key=>$departament)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$departament->name}}</td>
            <td>{{$departament->budget}}</td>
            <td></td>
            <td>{{$departament->balance}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@stop