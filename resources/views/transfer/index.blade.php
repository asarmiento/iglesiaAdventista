@extends('layouts.layouts')
@section('title')
Tipos de Ingresos
@stop
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@stop
@section('title-form')
Lista de Transferencias
@stop

@section('content')
    <div class="panel-body">
        <div class="text-center"><h1>Lista de Transferencias</h1></div>
        <div class="btn btn-info"><a href="{{route('ddd-store')}}"  class="button radius">Nuevo</a></div>
        <div class="panel-body">
        <table id="type_fix" class="table-bordered">
            <thead>
                <tr>
                    <th width="200">Nº</th>
                    <th width="150">Fecha</th>
                    <th width="150">Departamento</th>
                    <th width="150">Voto</th>
                    <th width="150">Detalle</th>
                    <th width="150">Tipo</th>
                    <th width="150">monto</th>
                    <th width="150">Editar</th>
               </tr>
            </thead>
            <tbody>
                  @foreach($transfers AS $key=>$transfer)
                <tr>
            <td>{{$key+1}}</td>

                        <td>{{$transfer->date}}</td>
                    <td>{{$transfer->departaments->name}}</td>
                    <td>{{utf8_decode($transfer->vote)}}</td>
                    <td>{{utf8_decode($transfer->detail)}}</td>
                    <td>{{utf8_decode($transfer->type)}}</td>
                    <td>{{number_format($transfer->amount,2)}}</td>
                    <td class="text-center"><a  href="#"><span class="glyphicon glyphicon-pencil"></span></a></td>
            </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('js/lib/dataTables.bootstrap.js') }}"></script>
@stop