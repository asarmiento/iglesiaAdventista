@extends('layouts.layouts')
@section('title')
Miembros
@stop

@section('title-form')
Lista Miembros
@stop

@section('content')

<div class="panel-body">
    <div class="btn btn-info"><a href="{{route('periodos-create')}}"  class="button radius">Cambiar de Periodo</a></div>
    <div class="panel-body">
        <table id="table_member" class="table-bordered">
            <thead>
            <tr>
                <th>Nº</th>
                <th width="250">Periodo</th>
                <th width="250">Fecha Inicio</th>
                <th width="250">Fecha Final</th>
                <th width="50"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($periods AS $key=>$period)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$period->month}}-{{$period->year}}</td>
                    <td>{{$period->dateIn}}</td>
                    <td>{{$period->dateOut}}</td>
                    <td class="text-center"><a target="_blank" href="{{route('informe-mensual-period',$period->token)}}"><span class="fa fa-file-pdf-o"></span></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop