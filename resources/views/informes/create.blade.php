@extends('layouts.layouts')
@section('title')
Informes Semanales
@stop

@section('title-form')
Lista Informes Semanales
@stop

@section('content')
    <div class="panel">

<div>@include('partials/errors')</div>
<div>@include('partials/message')</div>
<form action="{{route('save-record')}}" method="post" role="form" class="form-inline">
<table class="table">



    <tbody >
        {{csrf_field()}}
        <tr>
            <th><label>Numero #:</label></th>
            <td><input name="numbers" readonly  type="number" value="{{$consecutive}}"></td>
            <th><label>Fecha:</label></th>
            <td><input name="saturday"  type="date"></td>
            <th><label>Numero de Control Interno:</label></th>
            <td><input name="controlNumber"  type="number"></td>
        </tr>
    <tr>
        <th><label>Cantidad Filas:</label></th>
        <td><input name="rows"  type="number"></td>
        <th><label>Total:</label></th>
        <td><input name="balance"  type="number"></td>
    </tr>

    <tr>
        <td><a href="{{url()}}/iglesia/informes"  class="btn btn-info radius">Regresar</a></td>
        <td class="center-block" colspan="6"><input type="submit" value="Agregar" class="btn btn-info radius" /></td>
    </tr>
    </tbody>
</table>
</form>

    </div>
@stop