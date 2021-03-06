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
    <form action="{{route('checks-save')}}" method="post">
        <div class="row">
            <div class="col-sm-7 col-md-7">
                <label for="period">Periodo de Trabajo: </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                    <input name="period_id" class="form-control" readonly type="text" value="{{period()}}" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Cuenta Bancaria: </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-university"></i></span>
                    <select name="account_id" class="form-control select2" >
                        @foreach($accounts AS $account)
                            <option value="{{$account->id}}">{{convertTitle($account->name)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                <div class="col-sm-6 col-md-6">
                <label for="date">fecha </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input name="date" class="form-control" type="date" >
                </div>
            </div>
            {{ csrf_field() }}
            <div class="col-sm-6 col-md-6">
                <label for="date">Numero Cheque: </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="number" class="form-control" type="text" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Beneficiario: </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input name="name" class="form-control" type="text" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Monto</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    <input name="church_id" class="form-control" type="hidden" value="1" >
                    <input name="balance" class="form-control" type="text" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Tipo de Cheque</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-check"></i></span>
                    <select name="type" class="form-control select2" >
                        <option value="iglesia">Gastos Iglesia</option>
                        <option value="campo">Informe Semanal</option>

                    </select>
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