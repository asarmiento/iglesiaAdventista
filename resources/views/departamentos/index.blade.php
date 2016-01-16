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
            <td>{{number_format($departament->income,2)}}</td>
            <td>{{number_format($departament->expense,2)}}</td>
        </tr>
        @endforeach

    </tbody>
</table>
    <table class="table-condensed">
        <tbody>
        <tr class="color-green">
            <td></td>
            <td>Total</td>
            <td>Presupuesto: {{number_format($totalPresupuesto,2)}}</td>
            <td>Ingresos: {{number_format($totalIncomes,2)}}</td>
            <td>Gastos: {{number_format($totalExpenses,2)}}</td>
            <td class="color-red">Disponible para gasto: {{number_format($totalIncomes-($totalPresupuesto+$totalExpenses),2)}}</td>
        </tr>
        </tbody>
    </table>
</div>
@stop