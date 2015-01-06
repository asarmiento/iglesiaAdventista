@extends('layouts.layouts')
@section('title')
{{$action}} Departamentos
@stop

@section('title-form')
Formulario {{$action}} Departamentos
@stop

@section('content')
{{Form::model($departamentos,$form_data,array('role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="large-4 columns">
        <label class="">Nombre Departamentos
            {{Form::input('text','name',null,array('placeholder'=>"Departamentos"))}}
        </label>
        <small class="error-message red-message">{{$errors->first('name')}}</small>
    </div>
    <div class="large-4 columns">
        <label class="">Saldo Disponible
            {{Form::input('text','saldo',null,array('placeholder'=>"Saldo Disponible"))}}
        </label>
        <small class="error-message red-message">{{$errors->first('saldo')}}</small>
    </div>
    <div class="large-4 columns">
        <label class="">Iglesia
            {{Form::select('iglesias_id',$iglesia,array('placeholder'=>"Iglesia"))}}
        </label>
        <small class="error-message red-message">{{$errors->first('iglesias_id')}}</small>
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