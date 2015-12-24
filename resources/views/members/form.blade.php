@extends('layouts.layouts')
@section('title')
{{$action}} Miembros
@stop

@section('title-form')
Formulario {{$action}} Miembros
@stop

@section('content')
    <div class="panel">
    <div>@include('partials/errors')</div>
    <form method="POST" action="{{route('crear-members')}}" accept-charset="UTF-8" role='form' class='form-inline'>

<table class="table-condensed">

    <tr>
       <th>
           <label class="">Nombre Miembro</label>
       </th>
       <td>
           <input type="text" placeholder="Nombre Miembro" name="name">
           <small class="error-message red-message">{{$errors->first('name')}}</small>
       </td>
        <th>
            <label>Apellido Miembro </label>
        </th>
        <td>
            <input type="text" placeholder="Apellido Miembro" name="last">
            <small class="error-message red-message">{{$errors->first('last')}}</small>
        </td>
        <th>
            <label>Fecha Bautizmo</label>
        </th>
        <td>
            <input type="date" placeholder="2014-12-31" name="bautizmoDate">
            <small class="error-message red-message">{{$errors->first('bautizmoDate')}}</small>
        </td>
    </tr>
    <tr>
        <th>
            <label class="">Fecha Nacimiento</label>
        </th>
        <td>
            <input type="date" placeholder="2014-12-31" name="birthdate">
            <small class="error-message red-message">{{$errors->first('birthdate')}}</small>
        </td>
        <th>
            <label>Telefono</label>
        </th>
        <td>
            <input type="number" placeholder="Telefono" name="phone">
            <small class="error-message red-message">{{$errors->first('phone')}}</small>
        </td>
        <th>
            <label>Celular</label>
        </th>
        <td>
            <input type="number" placeholder="Celular" name="cell">
            <small class="error-message red-message">{{$errors->first('cell')}}</small>
        </td>
    </tr>
    <tr class="">
        <th>
            <label class="">Correo Electronico </label>
        </th>
        <td>
            <input type="text" placeholder="contactos@gmail.com" name="email">
        </td>

        <td>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </td>

        <input type="hidden" value="{{$iglesia[0]}}" name="church_id">
            <small class="error-message red-message">{{$errors->first('church_id')}}</small>
    </tr>

<tr class="media-middle text-center">
    <td colspan="7">
        <input type="submit" value="{{$action}}" class="btn btn-info radius" />
    </td>
</tr>
</table>
    </form>
    </div>
@stop