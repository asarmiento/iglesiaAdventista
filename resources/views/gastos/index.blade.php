@extends('layouts.layouts')
@section('title')
Gastos
@stop

@section('title-form')
Lista Gastos
@stop

@section('content')
<table>
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
        @foreach($gastos AS $gasto)
        <tr>
            <td></td>
            <td>{{$gasto->}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop