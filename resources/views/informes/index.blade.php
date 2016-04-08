@extends('layouts.layouts')
@section('title')
Informes Semanales
@stop

@section('title-form')
Lista Informes Semanales
@stop

@section('content')
    <div class="panel panel-body">
<div class="btn btn-info"><a href="{{route('create-record')}}"  class="button radius">Nuevo Informe</a></div>
        <div class="panel-body">
            <div>
                <a href="{{route('dep-Ingresos',2015)}}">Depositos Contra Informes 2015</a>
                <a href="{{route('dep-Ingresos',2016)}}">Depositos Contra Informes 2016</a>
            </div>
<table id="table_informe" class="table table-bordered">

    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Numero</th> 
            <th width="150">Numero de Control</th>
            <th width="150">Lineas</th>
            <th width="180">Sábado</th>
            <th width="150">Monto</th>
            <th width="150">Monto Mision/Asoc.</th>
            <th width="50">Ver / Ingresar</th>
            <th width="50">Pdf</th>
            <th width="50">Dep. Iglesia</th>
            <th width="50">Dep. Mision/Asoc</th>
            <th width="50">Enviar Asoc.</th>
        </tr>
    </thead> 
    <tbody> 
        @foreach($informes AS $key => $informe)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$informe->numbers}}</td>
            <td>{{$informe->controlNumber}}</td>
            <td>{{$informe->rows}}</td>
            <td>{{$informe->saturday}}</td>
            <td>{{number_format($informe->balance,2)}}</td>
            <td>{{number_format($informe->mision,2)}}</td>
            @if(($informe->incomes->isEmpty()))
            <td><a href="{{route('create-income',$informe->_token)}}"><i class="fa fa-book"></i></a></td>
            @else
            <td><a target="_blank" href="{{route('informe-semanal',$informe->_token )}}"><i class="fa fa-check"></i></a></td>
            @endif
            <td><a target="_blank"  href="{{route('post-report',$informe->saturday )}}"><i class="fa fa-file-pdf-o"></i></a></td>

            @if(($informe->deposit == 'YES'))
                <td><a><i class="fa fa-check"></i></a></td>
            @else
                <td><a target="_blank" href="{{route('create-deposit')}}"><i class="fa fa-empire"></i></a></td>
            @endif

            @if(($informe->campo == 'true'))
                <td><a><i class="fa fa-check"></i></a></td>
            @else
                <td><a target="_blank" href="{{route('create-deposit-campo')}}"><i class="fa fa-empire"></i></a></td>
            @endif

            <td><a href="{{route('send-income',$informe->_token)}}"><i class="fa fa-paper-plane"></i></a></td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
    </div>
@stop