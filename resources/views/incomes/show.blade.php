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
        <div class="row ">
                <div class="text-center">
                    <h2>Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día</h2>
                    <h4>Apartado 10113-1000 San José, Costa Rica</h4>
                    <h4>Teléfonos: 2224-8311 Fax:2225-0665</h4>
                    <h4>acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com</h4>
                    <h2>Control Semanal de Diezmos y Ofrendas</h2>
                    <div class="row"><h4 class="pull-left">Iglesia: Quepos</h4> <h4 class="pull-right">Fecha:  {{$control->saturday}} </h4></div>
                </div>
                <div class="panel-body">
                <table class=" table table-bordered ">
                    <thead class="headerTable color-green">
                    <tr>
                        <th>#</th>
                        <th>Miembros</th>
                        <th>Recibo N°</th>
                        @foreach($typeIncomes AS $typeIncome)
                            @if($income->where('type_income_id',$typeIncome->id)->where('date',$control->saturday)->sum('balance') >0 )
                                <th>{{convertTitle($typeIncome->name)}}</th>
                            @endif
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($members AS $member)
                        @if($income->where('member_id',$member->id)->where('date',$control->saturday)->sum('balance') >0 )
                            <tr style="margin: 2px"><?php $i++; ?>
                                <td>{{$i}}</td>
                                <td style="margin: 4px">{{convertTitle($member->completo())}}</td>

                                <td style="margin: 4px">{{$member->incomes->numberOf}}</td>
                                @foreach($typeIncomes AS $typeIncome)
                                    @if($income->where('type_income_id',$typeIncome->id)->where('date',$control->saturday)->sum('balance') >0 )
                                        <td style="margin: 4px">{{number_format($member->incomes->treeWhere('type_income_id',$typeIncome->id,'member_id',$member->id,'date',$control->saturday),2)}}</td>
                                    @endif
                                @endforeach

                            </tr>
                        @endif
                    @endforeach
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total _ _ _ _ _</strong></td>
                            @foreach($typeIncomes AS $typeIncome)
                                @if($income->where('type_income_id',$typeIncome->id)->where('date',$control->saturday)->sum('balance') >0 )
                                    <td style="margin: 4px"><strong>{{number_format($income->twoWhere('type_income_id',$typeIncome->id,'date',$control->saturday),2)}}</strong></td>
                                @endif
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
    </div>
@stop