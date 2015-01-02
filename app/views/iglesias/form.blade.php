@extends('layouts.layouts')
@section('title')
{{$action}} Iglesia
@stop

@section('title-form')
Formulario {{$action}} Iglesia
@stop

@section('content')
{{Form::model($iglesia,$form_data,array('role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="large-4 columns">
        <label class="">Nombre Iglesia
          {{FORM::input('text','name',null,array('placeholder'=>"Nombre Iglesia"))}}
      </label>
            <small class="error-message red-message">{{$errors->first('name')}}</small>
    </div>
    <div class="large-4 columns">
      <label>Telefono
         {{FORM::input('text','phone',null,array('placeholder'=>"Telefono"))}}
        <div class="error-message red-message">{{$errors->first('phone')}}</div>
      </label>
    </div>
      <div class="large-4 columns">
      <label>Mision o Asociación
          {{FORM::select('misions_id',$dropdown,array('placeholder'=>"Nombre Iglesia"))}}
          <div class="error-message red-message">{{$errors->first('misions_id')}}</div>
      </label>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <label>Dirección
          {{FORM::text('address',null,array('placeholder'=>"Dirección"))}}
        <div class="error-message red-message">{{$errors->first('address')}}</div>
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