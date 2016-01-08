@extends('layouts.layouts')
@section('title')
    Cheques
@stop

@section('title-form')
    <h1>Formulario Ingreso de Cheques</h1>
@stop

@section('content')
    <div>@include('partials/errors')</div>
    <form action="{{route('checks-save')}}" method="post">
        <div class="row">
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
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="name" class="form-control" type="text" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Cuenta Bancaria: </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <select name="account_id" class="form-control select2" >
                        @foreach($accounts AS $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Monto</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="church_id" class="form-control" type="hidden" value="1" >
                    <input name="balance" class="form-control" type="text" >
                </div>
            </div>
        </div>
        </br>
        <div class="row">
            <div class="large-12 columns text-center">
                <input type="submit" value="Guardar" class="btn btn-info radius" />
            </div>
        </div>
    </form>
@stop