<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 29/01/16
 * Time: 05:28 PM
-->
@extends('layouts.layouts')
@section('title')
    Traspaso de Fondos
@stop

@section('title-form')
    Formulario Ingreso de Gastos
@stop

@section('content')
    <div>@include('partials/errors')</div>
    <div>@include('partials/message')</div>
    <div class="panel-body text-center">
        <h2>Traspaso de Fondos Por Voto de Junta</h2>

    </div>
    <form action="{{route('traspaso-store')}}" method="post">
        <div class="row">
            <div class="col-sm-7 col-md-7 text-center">
                <label for="date">fecha </label>
                <div class="input-group text-center">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input name="date"  value="{{date('Y-m-d')}}" class="form-control" type="date" >
                </div>
            </div>
            <div class="col-sm-9 col-md-9">
                <label for="date">Departamento</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <select name="departament_id" class="form-control select2">
                        <option value="">Elija un Departamento</option>
                        @foreach($departaments AS $departament)
                            <option value="{{$departament->id}}">{{$departament->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <label for="date">Numero de Voto</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input name="votoTraspaso"  class="form-control" type="text" >
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <label for="date">Detalle del Traspaso</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="detail" class="form-control" type="text" >
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <label for="date">Monto </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                    <input name="amountTraspaso" placeholder="0.00"  class="form-control" type="text" >
                </div>
            </div>
            {{csrf_field()}}

        </div>
        </br>
        <div class="row">
            <div class="large-12 columns text-center">
                <input type="submit" value="Guardar" class="btn btn-info radius" />
            </div>
        </div>
    </form>

    <div>


    </div>
@stop