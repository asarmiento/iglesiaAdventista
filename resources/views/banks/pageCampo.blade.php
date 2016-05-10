<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/03/16
 * Time: 10:07 PM
-->

@extends('layouts.layouts')
@section('title')
    Cheques
@stop

@section('title-form')
    <h1>Formulario Ingreso de Cheques</h1>
@stop

@section('content')
    <div>@include('partials/errors')</div>
    <div>@include('partials/message')</div>
    <form action="{{route('report-campo')}}" method="post">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <label for="date">fecha Inicio</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input name="dateIn" class="form-control" type="date" >
                </div>
            </div>
            {{ csrf_field() }}
            <div class="col-sm-6 col-md-6">
                <label for="date">Fecha Final: </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="dateOut" class="form-control" type="date" >
                </div>
            </div>
        </div>
        </br>
        <div class="row">
            <div class="large-12 columns text-center">
                <td><a href="{{url()}}/iglesia/cheques"  class="btn btn-info radius">Regresar</a></td>
                <input type="submit" value="Guardar" class="btn btn-info radius" />
            </div>
        </div>
    </form>
@stop