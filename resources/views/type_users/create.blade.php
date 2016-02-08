@extends('layouts.layouts')
@section('title')
Ingresar Tipos Usuarios
@stop

@section('title-form')
Formulario Ingreso de Tipos Usuarios
@stop

@section('content')

<div class="row">
    <div class="large-4 columns">
        <label class="">Nombre Tipo Usuarios
            <input class="form-control" id="nameTypeUser" >
        </label>
    </div>

    <div class="large-12 columns text-center">
        <a href="#" id="saveTypeUser" data-url="tipo-de-usuario" class="btn btn-primary">Grabar Tipo Usuario</a>
    </div>
</div>

@stop