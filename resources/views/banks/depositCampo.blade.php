<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 03/03/16
 * Time: 08:57 PM
-->


@extends('layouts.layouts')
@section('title')
    Depositos Al Campo Local de los Informes
@stop
@section('title-form')
    Lista Depositos Bancarios
@stop

@section('content')
    <div class="btn btn-info"><a href="{{route('create-deposit-campo')}}"  class="button radius">Nueva Deposito</a></div>
    <div class="panel-body">
        <table  id="table_deposit" class="table-bordered">
            <thead>
            <tr>
                <th>Nº</th>
                <th width="200">Informe Semanal</th>
                <th width="200">Cheque</th>
                <th width="200">N° Deposito</th>
                <th width="150">Monto</th>
                <th width="200">Fecha</th>
                <th width="50">Ver</th>
                <th width="50">Estado de Cuenta</th>
            </tr>
            </thead>
            <tbody>
            @foreach($deposits AS $key => $deposit)
                <tr>
                    <td>{{$key+1}}</td>
                    @if($deposit->record_id)
                        <td>Informe: {{$deposit->records->controlNumber}} {{$deposit->records->saturday}}</td>
                    @endif
                        @if($deposit->check_id)
                        <td>Cheque: {{$deposit->checks->number}}</td>
                    @endif
                    <td>{{($deposit->number)}}</td>
                    <td>{{number_format($deposit->amount,2)}}</td>
                    <td>{{($deposit->date)}}</td>
                   <td></td>
                    <td><a href=""><i class="fa fa-eye"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script type="text/javascript">

        $(document).ready(function(){
            $("#table_gastos").DataTable();
        });
    </script>
@stop