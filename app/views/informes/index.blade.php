@extends('layouts.layouts')
@section('title')
Informes Semanales
@stop

@section('title-form')
Lista Informes Semanales
@stop

@section('content')
<div><a href="{{url()}}/informes/create"  class="button radius">Nuevo Informe</a></div>
<table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Numero</th> 
            <th width="150">Sábado</th> 
            <th width="150">Monto</th> 
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
        @foreach($informes AS $informe)
        <tr>
            <td></td>
            <td>{{$informe->numero}}</td>
            <td>{{$informe->sabado}}</td>
            <td>{{$informe->saldo}}</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop