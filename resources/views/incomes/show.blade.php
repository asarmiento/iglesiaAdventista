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

            <div class="row">
                <table class="table-bordered">
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
                    <tr style="margin: 2px">
                        <td>{{$i+1}}</td>
                        <td style="margin: 4px">{{$member->name}}</td>
                        <td style="margin: 4px">
                            </td>
                        @foreach($fixeds AS $fixed)
                            <td style="margin: 4px"><input type="text" placeholder="0.00" name="fixeds-{{$i}}-{{$fixed->id}}" style="height:30px; margin: 4px" size="10"></td>
                        @endforeach
                        @foreach($temporaries AS $temporary)
                            <td style="margin: 4px"><input type="text" placeholder="0.00" name="temporary-{{$i}}-{{$temporary->id}}" style="height:30px; margin: 4px" size="5"></td>
                        @endforeach
                        <td></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
    </div>
@stop