@extends('layouts.layouts')
@section('title')
{{$action}} Miembros
@stop

@section('title-form')
Formulario {{$action}} Miembros
@stop

@section('content')
    <div>@include('partials/errors')</div>
    <form method="POST" action="{{route('crear-members')}}" accept-charset="UTF-8" role='form' class='form-inline'>

<div class="row">

    <div class="large-4 columns">
        <label class="">Nombre Miembro</label>
        <input type="text" placeholder="Nombre Miembro" name="name">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
            <small class="error-message red-message">{{$errors->first('name')}}</small>
    </div>
    <div class="large-4 columns">
      <label>Apellido Miembro </label>
        <input type="text" placeholder="Apellido Miembro" name="last">
        <div class="error-message red-message">{{$errors->first('last')}}</div>
    </div>
      <div class="large-4 columns">
      <label>Fecha Bautizmo</label>
          <input type="date" placeholder="2014-12-31" name="bautizmoDate">
          <div class="error-message red-message">{{$errors->first('bautizmoDate')}}</div>
    </div>
  </div>
<div class="row">
    <div class="large-4 columns">
        <label class="">Fecha Nacimiento</label>
        <input type="date" placeholder="2014-12-31" name="birthdate">
            <small class="error-message red-message">{{$errors->first('birthdate')}}</small>
    </div>
    <div class="large-4 columns">
      <label>Telefono</label>
        <input type="number" placeholder="Telefono" name="phone">
       <div class="error-message red-message">{{$errors->first('phone')}}</div>


    </div>
      <div class="large-4 columns">
      <label>Celular</label>
          <input type="number" placeholder="Celular" name="cell">
          <div class="error-message red-message">{{$errors->first('cell')}}</div>
    </div>
  </div>
<div class="row">
    <div class="large-5 columns">
        <label class="">Correo Electronico </label>
        <input type="text" placeholder="contactos@gmail.com" name="email">
        <input type="hidden" value="{{$iglesia[0]}}" name="church_id">
            <small class="error-message red-message">{{$errors->first('church_id')}}</small>
    </div>

     
  </div>
</br>
<div class="row">
    <div class="large-12 columns text-center">
        <input type="submit" value="{{$action}}" class="button radius" />
    </div>
</div>
    </form>

@stop