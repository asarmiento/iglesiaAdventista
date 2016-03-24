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
        <table  id="deposit_igle" class="table-bordered">
            <thead>
            <tr>
                <th>Nº</th>
                <th width="200">Tipo Deposito</th>
                <th width="200">Numero Deposito</th>
                <th width="150">Fecha</th>
                <th width="200">Monto Informe</th>
                <th width="200">Monto Deposito</th>
                <th width="50">Ver</th>
                <th width="50">Estado de Cuenta</th>
            </tr>
            </thead>
            <tbody>
            @foreach($deposits AS $key => $deposit)
                <tr>
                    <td>{{$key+1}}</td>
                    @if($deposit->record_id)
                    <td>Informe: {{$deposit->records->controlNumber}}</td>
                    <td>Informe: {{$deposit->records->balanceyhhhhhhhhhhhhhhh}}</td>
                    @elseif($deposit->check_id)
                    <td>Cheque: {{$deposit->checks}}</td>
                    @endif
                    <td>{{($deposit->number)}}</td>
                    <td>{{($deposit->date)}}</td>
                    <td>{{number_format($deposit->balance,2)}}</td>
                    <td></td>
                    <td><a href=""><i class="fa fa-eye"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@stop