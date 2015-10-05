@extends('layouts.layouts')

@section('title')
    Iglesias
@stop

@section('page')
    <h2>Iglesias</h2>
    <ul>
        <li><a href="{{url()}}">Home</a></li>
        <li><a class="active">Iglesias</a></li>
    </ul>
@stop

@section('content')
    <div class="col-lg-12">
        <div class="tableData">
            <div class="headerTable">
                <h5><strong>Lista de Iglesias</strong></h5>
            </div>
            <div class="contentTable">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">N°</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Desactivar</th>
                                <th class="text-center">Activar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($iglesias as $iglesia)
                            <tr>
                                <td class="text-center iglesia_number">{{$iglesia->id}}</td>
                                <td class="iglesia_name">{{{mb_convert_case($iglesia->name, MB_CASE_TITLE, 'UTF-8')}}}</td>
                                <td class="iglesia_address">{{{mb_convert_case($iglesia->address, MB_CASE_TITLE, 'UTF-8')}}}</td>
                                <td class="text-center iglesia_phone">{{{$iglesia->phone}}}</td>
                                @if($iglesia->deleted_at)
                                    <td class="text-center iglesia_state">Inactivo</td>
                                @else
                                    <td class="text-center iglesia_state">Activo</td>
                                @endif
                                <td class="text-center">
                                    <a class="btn btn-info" href="#" id="editIglesia"><span class="glyphicon glyphicon-pencil"></span></a>
                                </td>
                                <td class="text-center">
                                    @if($iglesia->deleted_at)
                                        -
                                    @else
                                         <a id="btnDisabledIglesia" class="btn btn-danger" href="#" data-resource="iglesias"><span class="glyphicon glyphicon-trash"></span></a>
                                    @endif
                                   
                                </td>
                                <td class="text-center">
                                    @if($iglesia->deleted_at)
                                        <a id="btnEnabledIglesia" class="btn btn-success" href="#" data-resource="iglesias"><span class="glyphicon glyphicon-ok"></span></a>
                                    @else
                                        -
                                    @endif
                                   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a data-toggle="modal" data-target="#modalCreateIglesia" class="btn btn-md btn-success">Crear</a>
            </div>
        </div>
    </div>
<!-- Modal Edit Iglesia -->
<div class="modal fade" id="modalEditIglesia" data-success="0" tabindex="-1" role="dialog" aria-labelledby="editIglesiaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editIglesiaModalLabel">Editar Iglesia</h4>
            </div>
            <div class="modal-body">
                <input id="id_iglesia" type="hidden">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-iglesia">
                        <label for="name_iglesia">Nombre</label>
                        <input id="name_iglesia" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-iglesia">
                        <label for="address_iglesia">Dirección</label>
                        <input id="address_iglesia" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-iglesia">
                        <label for="phone_iglesia">Teléfono</label>
                        <input id="phone_iglesia" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-iglesia">
                        <label for="slcState_iglesia">Estado</label>
                        <select id="slcState_iglesia" class="form-control">
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 msgLadda">
                    <button id="btnLaddaEdit" class="btn ladda-button" data-style="expand-left" data-spinner-color="#000"><span class="ladda-label">Procesando la edición.</span><span class="ladda-spinner"></span></button>
                    <div id="msgEdit">
                       
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-footer-iglesia">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="btnUpdateIglesia" data-resource="iglesias" type="button" class="btn btn-success">Actualizar</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Iglesia -->

<!-- Modal Create Iglesia-->
<div class="modal fade" id="modalCreateIglesia" data-success="0" tabindex="-1" role="dialog" aria-labelledby="createIglesiaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="createIglesiaModalLabel">Crear Tipo de Usuario</h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-iglesia">
                        <label for="name_new_iglesia">Nombre</label>
                        <input id="name_new_iglesia" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-iglesia">
                        <label for="address_new_iglesia">Dirección</label>
                        <input id="address_new_iglesia" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-iglesia">
                        <label for="phone_new_iglesia">Teléfono</label>
                        <input id="phone_new_iglesia" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-iglesia">
                        <label for="slcState_new_iglesia">Estado</label>
                        <select id="slcState_new_iglesia" class="form-control">
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 msgLadda">
                    <button id="btnLaddaCreate" class="btn ladda-button" data-style="expand-left" data-spinner-color="#000"><span class="ladda-label">Procesando la creación.</span><span class="ladda-spinner"></span></button>
                    <div id="msgCreate">
                                        
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-footer-iglesia">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="btnCreateIglesia" data-resource="iglesias" type="button" class="btn btn-success">Crear</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Iglesia -->
@stop