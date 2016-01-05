@extends('layouts.layouts')
@section('title')
Tipos Fijos
@stop

@section('title-form')
Lista Tipos Fijos
@stop

@section('content')
    <div class="panel-body">
        <div class="btn btn-info"><a href="{{route('crear-typeFix')}}"  class="button radius">Nuevo</a></div>

        <table class="table-bordered">
            <thead>
                <tr>
                    <th width="200">Nº</th>
                    <th width="150">Nombre</th>
                    <th width="150">Ingreso</th>
                    <th width="150">Editar</th>
               </tr>
            </thead>
            <tbody>
                  @foreach($tiposfijos AS $key=>$tipoFijo)
                <tr>
            <td>{{$key+1}}</td>
            <td>{{$tipoFijo->name}}</td>
            <td>{{$tipoFijo->balance}}</td>
            <td><a class="btn btn-warning" href="{{route('typeFix-edit',$tipoFijo->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop