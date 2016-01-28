@extends('layouts.layouts')
@section('title')
Departamentos
@stop

@section('title-form')
Lista Departamentos
@stop

@section('content')
    <div class="text-center">
        <h2>Lista Departamentos de la Iglesia</h2>
    </div>
<div class="btn btn-info"><a href="{{route('create-depart')}}"  class="button radius">Nuevo</a></div>
<div class="panel-body">

<table id="table_depart" class="table table-bordered">
    <thead>
        <tr> 
            <th>Nº</th>
            <th>Departamento</th>
            <th>Presupuesto</th>
            <th>Gasado del Mes</th>
            <th>Saldo Mes</th>

            <th>Ing Año Ant.</th>
            <th>Gto Año Ant.</th>

            <th>Ing Año Act.</th>
            <th>Gto Año Act.</th>

            <th>Acum. Ing.</th>
            <th>Acum. Gto</th>
        </tr>
    </thead> 
    <tbody>
        @foreach($departaments AS $key=>$departament)
        <tr class="text-center">
            <td>{{$key+1}}</td>
            <td>{{$departament->name}}</td>
            <td>{{number_format($departament->budget,2)}}</td>
            <td>{{number_format($departament->month,2)}}</td>
            <td>{{number_format($departament->budget-$departament->month,2)}}</td>

            <td>{{number_format($departament->income,2)}}</td>
            <td>{{number_format($departament->expense,2)}}</td>

            <td></td>
            <td></td>
            <td>{{number_format($departament->allIncome,2)}}</td>
            <td>{{number_format($departament->allExpense,2)}}</td>
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