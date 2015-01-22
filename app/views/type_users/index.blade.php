@extends('layouts.layouts')

@section('title')
    Tipos de Usuario
@stop

@section('page')
    <h2>Tipo de Usuarios</h2>
    <ul>
        <li><a href="{{url()}}">Home</a></li>
        <li><a>Configuración</a></li>
        <li><a class="active">Tipo de Usuarios</a></li>
    </ul>
@stop

@section('content')
    <div class="col-lg-12">
        <div class="tableData">
            <div class="headerTable">
                <h5><strong>Lista por tipo de Usuarios</strong></h5>
            </div>
            <div class="contentTable">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nombre </th>
                                <th class="text-center">Editar </th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($typeusers as $typeuser)
                            <tr>
                                <td>{{$typeuser->id}}</td>
                                <td>{{$typeuser->name}}</td>
                                <td class="text-center">
                                    <a class="btn btn-warning" href="{{URL::action('TypeUsersController@edit',$typeuser->id)}}"><span class="glyphicon glyphicon-pencil"></span></a>
                                </td class="text-center">
                                <td class="text-center">
                                    <a class="btn btn-warning" href="{{URL::action('TypeUsersController@destroy',$typeuser->id)}}"><span class="glyphicon glyphicon-remove"></span></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{url()}}/type_users/create"  class="btn btn-md btn-success">Crear</a>
            </div>
        </div>
    </div>
@stop