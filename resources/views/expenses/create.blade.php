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
    <h2>Numero de Cheque: {{$checks->number}} Por: {{$checks->balance}} </h2>

    @if(($checks->balance-$checks->total)>0)
        <h2 class="color-green">Diferencia: {{$checks->balance-$checks->total}}</h2>
    @elseif(($checks->balance-$checks->total)<0)
        <h2 class="color-red">Diferencia: {{$checks->balance-$checks->total}}</h2>
    @endif
    </div>
   <form action="{{route('gasto-store')}}" method="post">
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <label for="date">fecha de Registro </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input name="date" readonly value="{{date('Y-m-d')}}" class="form-control" type="date" >
            </div>
        </div>
        {{csrf_field()}}

        <div class="col-sm-6 col-md-6">
            <label for="date">Tipo de Gasto</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-pencil-square"></i></span>
                <select name="type_expense_id" class="form-control select2">
                    <option value="">Elija una Opción</option>
                    @foreach($typeExpenses AS $typeExpense)
                        <option value="{{$typeExpense->id}}">{{convertTitle($typeExpense->name)}}</option>
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
            <label for="date">Fecha Factura del periodo</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                <input name="invoiceDate"  placeholder="0000-00-00" class="form-control" type="date" >
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <label for="date">Detalle de Factura</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-audio-description"></i></span>
                <input name="detail" class="form-control" type="text" >
                <input name="check_id" class="form-control" type="hidden" value="{{$checks->id}}">
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <label for="date">Monto de Factura</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-money"></i></span>
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
        @if($checks->expenses)
        <table class="table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Saldo Departamento</th>
                    <th>Departamento</th>
                    <th>Gasto</th>
                    <th>Detalle</th>
                    <th>Fecha</th>
                    <th>N°Factura</th>
                    <th>Monto</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody><?php ?>
                @foreach($checks->expenses AS $key=>$expense)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$expense->typeExpense->departament->balance}}</td>
                        <td>{{$expense->typeExpense->departament->name}}</td>
                        <td>{{$expense->typeExpense->name}}</td>
                        <td>{{$expense->detail}}</td>
                        <td>{{$expense->invoiceDate}}</td>
                        <td>{{$expense->invoiceNumber}}</td>
                        <td>{{$expense->amount}}</td>
                        <td class="text-center"><a href="{{route('delete-gasto',$expense->id)}}"><i class="fa fa-remove"></i></a></td>
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total: </td>
                        <td>{{$checks->total}}</td>
                    </tr>
            </tbody>
        </table>
            <div class="btn btn-info"><a href="{{route('checks-create')}}"  class="button radius">Finalizar</a></div>

        @endif
    </div>
@stop