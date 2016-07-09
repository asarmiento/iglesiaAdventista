@extends('layouts.layouts')
@section('title')
{{$action}} Tipos de Ingresos
@stop

@section('title-form')
Formulario {{$action}} Tipos de Ingresos
@stop

@section('content')
{!! Form::model($tiposfijo,$form_data,array('role'=>'form','class'=>'form-inline'))!!}
<div class="form-group">
    <div class="large-3 columns">
        <label class="">Nombre Tipo de Ingresos
            {!! Form::input('text','name',null,array('placeholder'=>"Tipos de Ingresos",'class'=>'form-control'))!!}
            {!! Form::input('hidden','church_id',$iglesia[0],array('placeholder'=>""))!!}

        </label>
    </div>
    <div  class="large-3 columns">
        <label>Abreviación para informe Semanal
            {!! Form::input('text','abreviation',null,array('placeholder'=>"Abreviacion de Tipo de Ingresos",'maxlength'=>'7','class'=>'form-control'))!!}

        </label>
        <small class="error-message red-message">{{$errors->first('name')}}</small>
    </div>
    <div  class="large-3 columns">
        <label>Departamento de la Iglesia</label>
        <select class="form-control select2" name="departament_id">
            <option value="">Selecciones un Departamento</option>
            @foreach($departaments As $departament)
            <option value="{{$departament->id}}">{{convertTitle($departament->name)}}</option>
            @endforeach
        </select>
    </div>
</div>
</br>
<div class="row">

    <div class="large-12 columns text-center">
        <a href="{{route('typeFix-lista')}}" class="btn btn-default"><i class="fa fa-ban"></i>Regresar</a>
        <input type="submit" value="{{$action}}" class="btn btn-info radius " />
    </div>
</div>
{!! Form::close()!!}
@stop