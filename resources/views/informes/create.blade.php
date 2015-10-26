@extends('layouts.layouts')
@section('title')
Informes Semanales
@stop

@section('title-form')
Lista Informes Semanales
@stop

@section('content')
<div><a href="{{url()}}/informes"  class="button radius">Regresar</a></div>
<div>@include('partials/errors')</div>
<form action="{{route('save-record')}}" method="post" role="form" class="form-inline">
<div class="row">
    <div>
        <input name="_token" type="hidden" value="{{csrf_token()}}">
    </div>
    <div class="form-group col-md-3">
        <label>Numero #:</label>
        <input name="numbers" disabled  type="number" value="{{$consecutive}}">
    </div>
    <div class="form-group col-md-2">
        <label>Fecha:</label>
        <input name="saturday"  type="date">
    </div>
    <div class="form-group col-lg-3 col-md-4">
        <label>Numero de Control Interno:</label>
        <input name="controlNumber"  type="number">
    </div>
    <div class="form-group col-md-3 col" >
        <label>Cantidad Filas:</label>
        <input name="rows"  type="number">
    </div>
    <div class="form-group col-md-2">
        <label>Total:</label>
        <input name="balance"  type="number">
    </div>
    <div class="btn-group-sm columns text-center col-md-6">
        <input type="submit" value="Agregar" class="button  radius" />
    </div>
</div>
</form>
@stop