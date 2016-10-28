@extends('layouts.layouts')
@section('title')
    Informe de Gastos
@stop

@section('title-form')
    Formulario  Gastos
@stop

@section('content')
    <div class="panel-primary">
        <div class="panel">@include('partials/errors')</div>
        <div class="row ">
            <div class="text-center">
                <h2>Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día</h2>
                <h4>Apartado 10113-1000 San José, Costa Rica</h4>
                <h4>Teléfonos: 2224-8311 Fax:2225-0665</h4>
                <h4>acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com</h4>
                <h2>Informe de Cheque de la Iglesia Adventista de Quepos</h2>
            </div>
            <div class="col-md-12 col-lg-12">
                <h3>Emitido a: {{$gastos[0]->check->name}}</h3>
            </div>
            <div class="col-md-4 col-lg-4">
                <h3>Numero Cheque: {{$gastos[0]->check->number}}</h3>
            </div>
            <div class="col-md-4 col-lg-4">
                <h3>fecha: {{$gastos[0]->check->date}}</h3>
            </div>
            <div class="col-md-4 col-lg-4">
                <h3>Monto: {{$gastos[0]->check->balance}}</h3>
            </div>
            <div class="col-md-12 col-lg-12">
                <table class="table ">
                    <thead class="headerTable ">
                        <tr>
                            <th>N° Factura</th>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            <th>Tipo de Gasto</th>
                            <th>Departamento</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($gastos AS $i => $gasto)
                        <tr>
                            <td>{{$gasto->invoiceNumber}}</td>
                            <td>{{$gasto->invoiceDate}}</td>
                            <td>{{$gasto->detail}}</td>
                            <td>{{$gasto->typeExpense->name}}</td>
                            <td>{{$gasto->typeExpense->departament->name}}</td>
                            <td>{{number_format($gasto->amount,2)}}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td>{{number_format($gastos[0]->total,2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop