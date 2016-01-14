@extends('layouts.layouts')
@section('title')
Tipos Variables
@stop

@section('title-form')
Lista Tipos Variables
@stop

@section('content')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#table_variable').DataTable();
        } );
    </script>
    <div class="text-center"><h1>Cuentas de Ingresos Variables</h1></div>
<div class="btn btn-info"><a href="{{route('crear-variableType')}}"  class="button radius">Nuevo</a></div>
    <div class="panel-body">
<table id="table_variable" class="table-bordered">
    <thead>
        <tr> 
            <th width="200">Nº</th>
            <th width="150">Departamento</th>
            <th width="150">Nombre</th>
            <th width="150">Ingresos</th>
            <th width="150">Salidas</th>
            <th width="150">Balance</th>
            <th width="150">Editar</th>
        </tr>
    </thead> 
    <tbody> 
         @foreach($tiposvariables AS $key=>$tipoVariable)
            <tr>
                    <td>{{$key+1}}</td>
                    @if($tipoVariable->departaments->isEmpty())
                        <td></td>
                    @else
                        <td>{{$tipoVariable->departaments[0]->name}}</td>
                    @endif
                    <td>{{$tipoVariable->name}}</td>
                <td>{{number_format($tipoVariable->income,2)}}</td>
                <td>{{number_format($tipoVariable->expense,2)}}</td>
                <td>{{number_format($tipoVariable->balance,2)}}</td>

                    <td><a class="btn btn-warning" href="{{route('variableType-edit',$tipoVariable->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
            </tr>
        @endforeach
    </tbody>
</table>
    </div>
@stop
