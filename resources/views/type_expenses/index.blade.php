@extends('layouts.layouts')
@section('title')
Tipos de Gastos
@stop

@section('title-form')
Lista Tipos de Gastos
@stop

@section('content')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#table_variable').DataTable();
        } );
    </script>
    <div class="text-center"><h1>Cuentas de Tipos de Gastos</h1></div>
<div class="btn btn-info"><a href="{{route('crear-typeExp')}}"  class="button radius"><i class="fa fa-neuter"></i> Nuevo</a></div>
    <div class="panel-body">
<table id="table_variable" class="table-bordered">
    <thead>
        <tr> 
            <th>Nº</th>
            <th>Departamento</th>
            <th>Nombre</th>
            <th>Salidas</th>
            <th>Balance</th>
            <th>Editar</th>
        </tr>
    </thead> 
    <tbody> 
         @foreach($typeExpenses AS $key=>$typeExpense)
            <tr>
                    <td>{{$key+1}}</td>
                    @if($typeExpense->departaments->isEmpty())
                        <td></td>
                    @else
                        <td>{{$typeExpense->departaments[0]->name}}</td>
                    @endif
                    <td>{{convertTitle($typeExpense->name)}}</td>
                <td>{{number_format($typeExpense->expense,2)}}</td>
                <td>{{number_format($typeExpense->balance,2)}}</td>

                    <td class="text-center"><a class="" href="{{route('typeExp-edit',$typeExpense->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
            </tr>
        @endforeach
    </tbody>
</table>
    </div>
@stop
