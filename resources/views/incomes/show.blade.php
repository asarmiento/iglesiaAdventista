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
                    <div class="row"><h4 class="pull-right">Iglesia: Quepos</h4> <h4 class="pull-left">Fecha:  de   de </h4></div>
                </div>
                <table class="table-bordered ">
                    <thead class="headerTable color-green">
                    <tr>
                        <th>#</th>
                        <th>Miembros</th>
                        <th>Recibo N°</th>
                        @foreach($fixeds AS $fixed)
                            <th>{{$fixed->name}}</th>
                        @endforeach
                        @foreach($temporaries AS $temporary)
                            <th>{{$temporary->name}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($members AS $i =>$member)
                        @if($member->incomes)
                            <tr style="margin: 2px">
                                <td>{{$i+1}}</td>
                                <td style="margin: 4px">{{$member->name}}</td>

                                <td style="margin: 4px">{{$member->incomes->numberOf}}</td>
                                @foreach($fixeds AS $fixed)
                                    <td style="margin: 4px">{{number_format($member->incomes->twoWhere('typeFixedIncome_id',$fixed->id,'member_id',$member->id))}}</td>
                                @endforeach
                                @foreach($temporaries AS $temporary)
                                    <td style="margin: 4px">{{number_format($member->incomes->twoWhere('typesTemporaryIncome_id',$temporary->id,'member_id',$member->id))}}</td>
                                 @endforeach
                                <td></td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@stop