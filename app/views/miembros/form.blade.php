@extends('layouts.layouts')
@section('title')
{{$action}} Miembros
@stop

@section('title-form')
Formulario {{$action}} Miembros
@stop

@section('content')
{{Form::model($miembro,$form_data,array('role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="large-4 columns">
        <label class="">Nombre Miembro
          {{FORM::input('text','name',null,array('placeholder'=>"Nombre Miembro"))}}
      </label>
            <small class="error-message red-message">{{$errors->first('name')}}</small>
    </div>
    <div class="large-4 columns">
      <label>Apellido Miembro
         {{FORM::input('text','last',null,array('placeholder'=>"Apellido Miembro"))}}
        <div class="error-message red-message">{{$errors->first('last')}}</div>
      </label>
    </div>
      <div class="large-4 columns">
      <label>Fecha Bautizmo
          {{FORM::input('text','date_bautizmo',null,array('placeholder'=>"2014-12-31",'id'=>'date_bautizmo'))}}
          <div class="error-message red-message">{{$errors->first('date_bautizmo')}}</div>
      </label>
    </div>
  </div>
<div class="row">
    <div class="large-4 columns">
        <label class="">Fecha Nacimiento
          {{FORM::input('text','date_nacimiento',null,array('placeholder'=>"2014-12-31",'id'=>'date_nacimiento'))}}
      </label>
            <small class="error-message red-message">{{$errors->first('date_nacimiento')}}</small>
    </div>
    <div class="large-4 columns">
      <label>Telefono
         {{FORM::input('text','phone',null,array('placeholder'=>"Telefono"))}}
        <div class="error-message red-message">{{$errors->first('phone')}}</div>
      </label>
    </div>
      <div class="large-4 columns">
      <label>Celular
          {{FORM::input('text','celular',null,array('placeholder'=>"Celular"))}}
          <div class="error-message red-message">{{$errors->first('celular')}}</div>
      </label>
    </div>
  </div>
<div class="row">
    <div class="large-5 columns">
        <label class="">Correo Electronico
          {{FORM::email('email',null,array('placeholder'=>"contactos@gmail.com"))}}
      </label>
            <small class="error-message red-message">{{$errors->first('email')}}</small>
    </div>
    <div class="large-5 columns">
      <label>Iglesia
          {{FORM::select('iglesias_id',$dropdown,array('placeholder'=>"Nombre Iglesia"))}}
          <div class="error-message red-message">{{$errors->first('iglesias_id')}}</div>
      </label>
    </div>
     
  </div>
</br>
<div class="row">
    <div class="large-12 columns text-center">
        <input type="submit" value="{{$action}}" class="button radius" />
    </div>
</div>
{{Form::close()}}
@stop