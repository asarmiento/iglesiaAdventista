@extends('layouts.layouts')
@section('title')
 Ingresos
@stop

@section('title-form')
Formulario  Ingresos
@stop

@section('content')
<div class="panel-primary">
    <div class="panel">@include('partials/errors')</div>
        <form method="post" action="{{route('incomes-store')}}" role='form' class='form-inline'>
        <div class="list-group">
            <div class="col-sm-3">
                <label class="">Numero Informe: {{$incomes->controlNumber}}</label>
                <input name="tokenControlNumber" type="hidden" value="{{$incomes->token}}">
            </div>
            <div class="col-sm-3">
                <label class="">Fecha: {{$incomes->saturday}}</label>
                {{csrf_field()}}
                <input name="date" type="hidden" value="{{$incomes->saturday}}">
            </div>
            <div class="col-sm-3">
                <label class="">Saldo Disponible: <span class="balance">{{number_format($incomes->balance)}}</span>
                </label>
                <input name="balanceControl" type="hidden" value="{{$incomes->balance}}">
            </div>
            <div class="col-sm-3">
                <label>Saldo Por Ingresar: <span class="balance_in">{{number_format($incomes->balance)}}</span>
                </label>
                <input name="balanceControl" type="hidden" value="{{$incomes->balance}}">
            </div>
        </div>
        <div class="row">
            <table class="table-bordered">
                <thead class="headerTable color-green">
                    <tr>
                        <th>#</th>
                        <th>Miembro</th>
                        <th>Numero Sobre</th>
                        @foreach($typeIncomes AS $typeIncome)
                        <th>{{$typeIncome->name}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                  <?php for($i=1;$i<=$incomes->rows;$i++): ?>
                    <tr style="margin: 2px">
                        <td>{{$i}}</td>
                        <td style="margin: 4px">
                            <select  name="members-{{$i}}" style="height:40px; margin: 4px" class="form-control select2" data-type="select" >
                                <option selected value="">Seleccione un Miembro</option>
                                @foreach($members AS $member)
                                    <option value="{{$member->token}}">{{$member->name.' '.$member->last}}</option>
                                @endforeach
                            </select></td>
                        <td style="margin: 4px"><input type="text" placeholder="Numero Sobre" name="numberAbout-{{$i}}" class="form-control" style="height:30px; margin: 4px" size="10"></td>
                        @foreach($typeIncomes AS $typeIncome)
                        <td style="margin: 4px"><input type="text" placeholder="0.00" name="fixeds-{{$i}}-{{$typeIncome->id}}" class="form-control number" style="height:30px; margin: 4px" size="10"></td>
                        @endforeach
                        <td></td>
                    </tr>
                  <?php endfor; ?>
                </tbody>
            </table>

        </div>
        <div class="row">
            <div class="large-12 columns text-center">
                <input type="submit" id="sendTotal" value="Registrar" class="btn bg-success radius" disabled="disabled" />
            </div>
        </div>
    </form>
</div>
@stop
