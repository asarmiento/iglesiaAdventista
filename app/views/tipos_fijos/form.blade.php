@extends('layouts.layouts')
@section('title')
{{$action}} Tipos Fijos
@stop

@section('title-form')
Formulario {{$action}} Tipos Fijos
@stop

@section('content')
{{Form::model($tiposfijo,$form_data,array('role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="large-4 columns">
        <label class="">Nombre Tipo Fijos
            {{Form::input('text','name',null,array('placeholder'=>"Tipos Fijos"))}}
        </label>
        <small class="error-message red-message">{{$errors->first('name')}}</small>
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