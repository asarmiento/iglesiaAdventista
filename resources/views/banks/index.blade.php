@extends('layouts.layouts')
@section('title')
Cuentas Bancarias
@stop
@section('title-form')
Lista Cuentas Bancarias
@stop

@section('content')
    <div class="btn btn-info"><a href="{{route('bank-create')}}"  class="button radius">Nueva Cuenta</a></div>
    <div class="panel-body">
<table  id="table_account" class="table-bordered">
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">N° Cuenta</th>
            <th width="200">Nombre de Banco</th>
            <th width="150">Balance Inicial</th>
            <th width="200">Total Ingresos</th>
            <th width="200">Total Salidas</th>
            <th width="150">Balance</th>
            <th width="50">Ver</th>
            <th width="50">Estado de Cuenta</th>
        </tr>
    </thead> 
    <tbody> 
        @foreach($banks AS $key => $bank)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$bank->code}}</td>
            <td>{{$bank->name}}</td>
            <td>{{number_format($bank->initial_balance,2)}}</td>
            <td>{{number_format($bank->debit_balance,2)}}</td>
            <td>{{number_format($bank->credit_balance,2)}}</td>
            <td>{{number_format($bank->balance,2)}}</td>
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