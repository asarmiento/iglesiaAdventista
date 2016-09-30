<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/04/16
 * Time: 01:11 PM
 -->
@extends('layouts.layouts')
@section('title')
    Informe
@stop

@section('title-form')
    Formulario Estado de Cuenta
@stop

@section('content')
    <div>@include('partials/errors')</div>
    <div>@include('partials/message')</div>
    <div class="panel-body text-center">

    </div>
    <div class="center-block"><h1>Informe Mensual por Periodo</h1></div>
    <form target="_blank" action="{{route('informe-Mensual')}}" method="post">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <label for="date">Fecha Inicial</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                    <select name="periods" class="form-control select2">
                        @foreach($periods AS $period)
                            <option value="{{$period->token}}">{{$period->month}}-{{$period->year}}</option>
                        @endforeach
                    </select>
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