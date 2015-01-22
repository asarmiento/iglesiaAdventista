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
                                <th class="text-center">N°</th>
                                <th>Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Desactivar</th>
                                <th class="text-center">Activar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($typeusers as $typeuser)
                            <tr>
                                <td class="text-center user_number">{{$typeuser->id}}</td>
                                <td class="user_name">{{$typeuser->name}}</td>
                                @if($typeuser->deleted_at)
                                    <td class="text-center user_state">Inactivo</td>
                                @else
                                    <td class="text-center user_state">Activo</td>
                                @endif
                                <td class="text-center">
                                    <a class="btn btn-info" href="#" id="editTypeUser"><span class="glyphicon glyphicon-pencil"></span></a>
                                </td>
                                <td class="text-center">
                                    @if($typeuser->deleted_at)
                                        -
                                    @else
                                         <a id="btnDisabledTypeUser" class="btn btn-danger" href="#" data-resource="type_users"><span class="glyphicon glyphicon-trash"></span></a>
                                    @endif
                                   
                                </td>
                                <td class="text-center">
                                    @if($typeuser->deleted_at)
                                        <a id="btnEnabledTypeUser" class="btn btn-success" href="#" data-resource="type_users"><span class="glyphicon glyphicon-ok"></span></a>
                                    @else
                                        -
                                    @endif
                                   
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
<!-- Modal Edit Type User-->
<div class="modal fade" id="modalEditTypeUser" tabindex="-1" role="dialog" aria-labelledby="editTypeUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editTypeUserModalLabel">Editar Tipo de Usuario</h4>
            </div>
            <div class="modal-body">
                <input id="id_typeUser" type="hidden">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <label for="name_typeUser">Nombre</label>
                    <input id="name_typeUser" class="form-control" type="text">
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <label for="slcState_typeUser">Estado</label>
                    <select id="slcState_typeUser" class="form-control">
                        <option value="0">Inactivo</option>
                        <option value="1">Activo</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Type -->
@stop