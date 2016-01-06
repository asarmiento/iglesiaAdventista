@extends('layouts.layouts')
@section('title')
Gastos
@stop

@section('title-form')
Lista Gastos
@stop

@section('content')
    <div>
<table id="table_gastos" class="table">
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Departamento</th> 
            <th width="150">Fecha</th> 
            <th width="150">Monto</th> 
            <th width="150">Descripcion</th> 
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
        @foreach($expenses AS $key=> $expense)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$expense->departaments->name}}</td>
            <td>{{$expense->date}}</td>
            <td>{{$expense->amount}}</td>
            <td>{{$expense->detail}}</td>
            <td></td>
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