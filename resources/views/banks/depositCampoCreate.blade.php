<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 03/03/16
 * Time: 07:55 PM
-->
@extends('layouts.layouts')
@section('title')
    Depositos Bancarias
@stop

@section('title-form')
    Formulario Ingreso de Depositos Bancarias
@stop

@section('content')
    <div>@include('partials/errors')</div>
    <div>@include('partials/message')</div>
    <div class="panel-body text-center">

    </div>
    <form action="{{route('store-deposit-campo')}}" method="post">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <label for="date">Cheques </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                    <select name="account_id" class="form-control" >
                        <option value="">Seleccione un Cheque</option>
                        @foreach($checks AS $check)
                            <option value="{{$check->id}}">{{$check->number}} {{$check->name}} {{$check->balance}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Numero Deposito</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                    <input name="number"  class="form-control" type="text" >
                </div>
            </div>
            {{csrf_field()}}

            <div class="col-sm-6 col-md-6">
                <label for="date">Informe Semanal</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <select name="record_id" class="form-control" >
                        <option value="">Seleccione un Informe</option>
                        @foreach($records AS $record)
                            <option value="{{$record->_token}}">{{$record->controlNumber}} {{$record->saturday}}  <b>{{number_format($record->balance,2)}} </b></option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Fecha</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="date" class="form-control" type="date" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Monto</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="balance" class="form-control" type="text" >
                </div>
            </div>
        </div>
        </br>
        <div class="row">
            <div class="large-12 columns text-center">
                <a href="{{route('deposito-ver')}}"  class="btn btn-default radius">Regresar</a>
                <input type="submit" value="Guardar" class="btn btn-info radius" />
            </div>
        </div>
    </form>

@stop