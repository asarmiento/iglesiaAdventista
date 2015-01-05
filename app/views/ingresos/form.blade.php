@extends('layouts.layouts')
@section('title')
{{$action}} Ingresos
@stop

@section('title-form')
Formulario {{$action}} Ingresos
@stop

@section('content')
{{Form::model($ingresos,$form_data,array('role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="large-4 columns">
        <label class="">Fecha
            {{Form::input('text','date',null,array('placeholder'=>"fecha",'id'=>'date'))}}
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