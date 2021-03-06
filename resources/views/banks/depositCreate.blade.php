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
   <form action="{{route('post-deposit')}}" method="post">
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <label for="date">Banco </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                <select name="account_id" class="form-control select2" >
                    <option value="">Seleccione una Cuenta Bancaria</option>
                    @foreach($accounts AS $account)
                        <option value="{{$account->id}}">{{$account->code}} {{$account->name}}</option>
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
                <select name="record_id" class="form-control select2" >
                    <option value="">Seleccione un Informe</option>
                    @foreach($records AS $record)
                        @if($record->balance >0)
                    <option value="{{$record->token}}">{{$record->controlNumber}} {{$record->saturday}}  <b>{{number_format($record->balance,2)}} </b></option>
                        @endif
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