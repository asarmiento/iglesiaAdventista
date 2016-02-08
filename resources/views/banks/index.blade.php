@extends('layouts.layouts')
@section('title')
Gastos
@stop

@section('title-form')
Lista Gastos
@stop

@section('content')
    <div class="panel-body">
<table  id="table_expense" class="table-bordered">
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Departamento</th> 
            <th width="200">Gasto</th>
            <th width="200">N° Ck</th>
            <th width="200">N° Factura</th>
            <th width="150">Fecha</th>
            <th width="150">Monto</th> 
            <th width="150">Descripcion</th> 
            <th width="50">Ver</th>
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
        @foreach($banks AS $key => $bank)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$bank->number}}</td>
            <td>{{$bank->date}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><a href=""><i class="fa fa-eye"></i></a></td>
            <td></td>
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