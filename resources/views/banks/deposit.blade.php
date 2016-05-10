<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 28/02/16
 * Time: 06:38 PM
 -->

@extends('layouts.layouts')
@section('title')
    Depositos Bancarias
@stop
@section('title-form')
    Lista Depositos Bancarias
@stop

@section('content')
    <div class="btn btn-info"><a href="{{route('create-deposit')}}"  class="button radius">Nueva Deposito</a></div>
    <div class="panel-body">
        <table  id="table_iglesia" class="table-bordered">
            <thead>
            <tr>
                <th>Nº</th>
                <th>Tipo Deposito</th>
                <th>Numero Deposito</th>
                <th>Fecha</th>
                <th>Numero Informe</th>
                <th>Monto Informe</th>
                <th>Monto Deposito</th>
              </tr>
            </thead>
            <tbody>
            @foreach($deposits AS $key => $deposit)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{($deposit->type)}}</td>
                    <td>{{($deposit->number)}}</td>
                    <td>{{($deposit->date)}}</td>
                    @if(!$deposit->records->isEmpty())
                    <td>#: {{$deposit->records[0]->controlNumber}}</td>
                    <td>Monto: {{number_format($deposit->records[0]->balance,2)}}</td>
                    @else
                    <td></td>
                    <td></td>
                    @endif
                    <td>{{number_format($deposit->balance,2)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@stop