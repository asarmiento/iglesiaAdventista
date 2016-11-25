@extends('layouts.layouts')
@section('title')
 Relacionar Tipos de Ingresos con Tipos de Gastos
@stop

@section('title-form')
Formulario  Relacionar Tipos de Ingresos con Tipos de Gastos
@stop

@section('content')
<form action="{{route('relation-save')}}" method="post" class="form-group">
<div class="form-group"> {{csrf_field()}}
    <div class="col-lg-3 col-md-3">
        <label class="">Tipo de Ingresos</label>
            <select class="form-control select2" name="type_income_id">
                <option value="">Selecciones un Ingreso</option>
                @foreach($typeIncomes As $typeIncome)
                    <option value="{{$typeIncome->id}}">{{convertTitle($typeIncome->name)}}</option>
                @endforeach
            </select>
    </div>
    <div  class="col-lg-3 col-md-3">
        <label class="">Tipo de Ingresos</label>
        <select class="form-control select2" name="type_expense_id">
            <option value="">Selecciones un Ingreso</option>
            @foreach($typeExpenses As $typeExpense)
                <option value="{{$typeExpense->id}}">{{convertTitle($typeExpense->name)}}</option>
            @endforeach
        </select>
    </div>
</div>
</br>
<div class="col-lg-3 col-md-3">

    <div class="large-12 columns text-center">
        <a href="{{route('typeFix-lista')}}" class="btn btn-default"><i class="fa fa-ban"></i>Regresar</a>
        <input type="submit" value="Relacionar" class="btn btn-info radius " />
    </div>
</div>
</form>
@stop