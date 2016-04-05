<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 29/01/16
 * Time: 05:28 PM
-->
@extends('layouts.layouts')
@section('title')
    Gastos
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
    <form action="{{route('gasto-store')}}" method="post">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <label for="date">fecha </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input name="date" readonly value="{{date('Y-m-d')}}" class="form-control" type="date" >
                </div>
            </div>
            {{csrf_field()}}

            <div class="col-sm-6 col-md-6">
                <label for="date">Tipo de Gasto</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <select name="type_expense_id" class="form-control select2">
                        <option value="">Elija una Opción</option>

                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Numero de Factura </label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="invoiceNumber" class="form-control" type="text" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">fecha Factura</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input name="invoiceDate"  placeholder="0000-00-00" class="form-control" type="date" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Detalle de Factura</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="detail" class="form-control" type="text" >
                    <input name="check_id" class="form-control" type="hidden" value="">
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Monto de Factura</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input name="amount" class="form-control" type="text" >
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

    <div>


    </div>
@stop