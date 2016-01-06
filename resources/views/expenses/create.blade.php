@extends('layouts.layouts')
@section('title')
    Gastos
@stop

@section('title-form')
    Formulario Ingreso de Gastos
@stop

@section('content')
    <h2>Numero de Cheque: {{$checks->number}} Por: {{$checks->balance}}</h2>
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
            <label for="date">Departamento</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                <select name="departament_id" class="form-control">
                    <option></option>
                    @foreach($departaments AS $departament)
                        <option value="{{$departament->id}}">{{$departament->name}}</option>
                    @endforeach
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
                <input name="check_id" class="form-control" type="hidden" value="{{$checks->id}}">
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
        @if($expenses)
        <table class="table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Departamento</th>
                    <th>Fecha</th>
                    <th>N°Factura</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody><?php ?>
                @foreach($expenses AS $key=>$expense)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$expense->departaments->name}}</td>
                        <td>{{$expense->invoiceDate}}</td>
                        <td>{{$expense->invoiceNumber}}</td>
                        <td>{{$expense->amount}}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total: </td>
                        <td>{{$total}}</td>
                    </tr>
            </tbody>
        </table>
            <div class="btn btn-info"><a href="{{route('index-gasto')}}"  class="button radius">Finalizar</a></div>

        @endif
    </div>
@stop