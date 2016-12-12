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
    <div class="col-lg-4 col-md-4">
        <label class="">Tipo de Ingresos</label>
            <select class="form-control select2" name="type_income_id">
                <option value="">Selecciones un Ingreso</option>
                @foreach($typeIncomes As $typeIncome)
                    <option value="{{$typeIncome->id}}">{{convertTitle($typeIncome->name)}}</option>
                @endforeach
            </select>
    </div>
    <div  class="col-lg-4 col-md-4">
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
<div class="col-lg-4 col-md-4">

    <div class="large-12 columns text-center">
        <a href="{{route('typeFix-lista')}}" class="btn btn-default"><i class="fa fa-ban"></i>Regresar</a>
        <input type="submit" value="Relacionar" class="btn btn-info radius " />
    </div>
</div>
</form>
    <div class="form-group">
        <div class="col-lg-10 col-md-10">
            <ul class="form-group">
                    @foreach($typeIncomes As $typeIncome)
                            <li style="align-content: inherit">{{$typeIncome->name}}-->{{number_format($typeIncome->balance)}} -->
                                <ul style="padding-left: 150px; color: #007dbb "> <?php $totalExpenses = 0; ?>
                                @foreach($typeIncome->typeExpenses As $typeExpense)
                                    <li>{{$typeExpense->id.'-'.$typeExpense->name}}-->{{number_format($typeExpense->balance)}}</li>
                                    <?php $totalExpenses += $typeExpense->balance; ?>
                                @endforeach
                                </ul>
                                <li style="padding-left: 200px;
                            <?php echo "color: #2ca02c"; if(($typeIncome->balance-$typeExpense->amount) < 0): echo "color:red"; endif;  ?>  ">
                                Saldo Disponible: {{number_format($typeIncome->balance-$totalExpenses)}}
                            </li>
                            </li>
                    @endforeach
            </ul>
        </div>
    </div>
@stop