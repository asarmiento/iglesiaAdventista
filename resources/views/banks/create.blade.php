@extends('layouts.layouts')
@section('title')
    Cuentas Bancarias
@stop

@section('title-form')
    Formulario Ingreso de Cuentas Bancarias
@stop

@section('content')
    <div>@include('partials/errors')</div>
    <div>@include('partials/message')</div>
    <div class="panel-body text-center">

    </div>
   <form action="{{route('bank-store')}}" method="post">
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <label for="date">Numero de Cuenta </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                <input name="code"  class="form-control" type="text" >
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <label for="date">Nombre de Banco </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                <input name="name"  class="form-control" type="text" >
            </div>
        </div>
        {{csrf_field()}}

        <div class="col-sm-6 col-md-6">
            <label for="date">Saldo inicial</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                <input name="initial_balance" class="form-control" type="text" >
            </div>
        </div>
    </div>
    </br>
    <div class="row">
        <div class="large-12 columns text-center">
            <a href="{{route('bank-ver')}}"  class="btn btn-default radius">Regresar</a>
            <input type="submit" value="Guardar" class="btn btn-info radius" />
        </div>
    </div>
   </form>

@stop