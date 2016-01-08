@extends('layouts.layouts')
@section('title')
Tipos Fijos
@stop
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@stop
@section('title-form')
Lista Tipos Fijos
@stop

@section('content')
    <div class="panel-body">
        <div class="btn btn-info"><a href="{{route('crear-typeFix')}}"  class="button radius">Nuevo</a></div>

        <table id="type_fix" class="table-bordered">
            <thead>
                <tr>
                    <th width="200">Nº</th>
                    <th width="150">Nombre</th>
                    <th width="150">Ingreso</th>
                    <th width="150">Salidas</th>
                    <th width="150">Balance</th>
                    <th width="150">Editar</th>
               </tr>
            </thead>
            <tbody>
                  @foreach($tiposfijos AS $key=>$tipoFijo)
                <tr>
            <td>{{$key+1}}</td>
            <td>{{$tipoFijo->name}}</td>
                    <td>{{number_format($tipoFijo->fixIncomes(),2)}}</td>
                    <td>{{number_format($tipoFijo->fixExponses(),2)}}</td>
                    <td>{{number_format($tipoFijo->balance,2)}}</td>
                    <td><a class="btn btn-warning" href="{{route('typeFix-edit',$tipoFijo->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('js/lib/dataTables.bootstrap.js') }}"></script>
@stop