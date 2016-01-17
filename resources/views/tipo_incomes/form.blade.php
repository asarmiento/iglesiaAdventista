@extends('layouts.layouts')
@section('title')
{{$action}} Tipos de Ingresos
@stop

@section('title-form')
Formulario {{$action}} Tipos de Ingresos
@stop

@section('content')
{!! Form::model($tiposfijo,$form_data,array('role'=>'form','class'=>'form-inline'))!!}
<div class="row">
    <div class="large-4 columns">
        <label class="">Nombre Tipo de Ingresos
            {!! Form::input('text','name',null,array('placeholder'=>"Tipos Fijos",'class'=>'form-control'))!!}
            {!! Form::input('hidden','church_id',$iglesia[0],array('placeholder'=>""))!!}

        </label>
        <small class="error-message red-message">{{$errors->first('name')}}</small>
    </div>
    <div  class="large-4 columns">
        <label>Departamento</label>
        <select class="form-control" name="departament_id">
            <option>Selecciones un Departamento</option>
            @foreach($departaments As $departament)
            <option value="{{$departament->id}}">{{$departament->name}}</option>
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