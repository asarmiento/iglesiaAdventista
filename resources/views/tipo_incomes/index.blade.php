@extends('layouts.layouts')
@section('title')
Tipos de Ingresos
@stop
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@stop
@section('title-form')
Lista Tipos de ingresos
@stop

@section('content')
    <div class="panel-body">
        <div class="text-center"><h1>Cuentas de Ingresos</h1></div>
        <div class="btn btn-info"><a href="{{route('crear-typeFix')}}"  class="button radius">Nuevo</a></div>
        <div class="panel-body">
        <table id="type_fix" class="table-bordered">
            <thead>
                <tr>
                    <th width="200">Nº</th>
                    <th width="150">Departamento</th>
                    <th width="150">Nombre</th>
                    <th width="150">Año Anterior</th>
                    <th width="150">Año Actual</th>
                    <th width="150">Balance</th>
                    <th width="150">Editar</th>
               </tr>
            </thead>
            <tbody>
                  @foreach($tipoincomes AS $key=>$tipoincome)
                <tr>
            <td>{{$key+1}}</td>
                    @if($tipoincome->departaments->isEmpty())
                        <td></td>
                    @else
                        <td>{{$tipoincome->departaments[0]->name}}</td>
                    @endif
            <td>{{$tipoincome->name}}</td>
                    <td>{{number_format($tipoincome->lastYear,2)}}</td>
                    <td>{{number_format($tipoincome->expense,2)}}</td>
                    <td>{{number_format($tipoincome->balance,2)}}</td>
                    <td class="text-center"><a  href="{{route('typeFix-edit',$tipoincome->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
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