<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/04/16
 * Time: 01:11 PM
 -->
@extends('layouts.layouts')
@section('title')
    Cuentas Bancarias
@stop

@section('title-form')
    Formulario Estado de Cuenta
@stop

@section('content')
    <div>@include('partials/errors')</div>
    <div>@include('partials/message')</div>
    <div class="panel-body text-center">

    </div>
    <form target="_blank" action="{{route('estado-de-cuenta')}}" method="post">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <label for="date">Fecha Inicial</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                    <input name="dateIn"  class="form-control" type="date" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Fecha Final</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                    <input name="dateOut"  class="form-control" type="date" >
                    <input name="id"  class="form-control" type="hidden" value="{{$account}}" >
                </div>
            </div>
            {{csrf_field()}}
        </div>
        </br>
        <div class="row">
            <div class="large-12 columns text-center">
                <a href="{{route('bank-ver')}}"  class="btn btn-default radius">Regresar</a>
                <input type="submit" value="Generar" class="btn btn-info radius" />
            </div>
        </div>
    </form>

@stop