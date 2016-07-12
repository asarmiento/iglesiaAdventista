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
    <div class="col-lg-3 col-md-3">
        <label class="">Nombre Tipo de Ingresos
            {!! Form::input('text','name',null,array('placeholder'=>"Tipos de Ingresos",'class'=>'form-control'))!!}
            {!! Form::input('hidden','church_id',$iglesia[0],array('placeholder'=>""))!!}

        </label>
    </div>
    <div  class="col-lg-3 col-md-3">
        <label>Abreviación para informe Semanal
            {!! Form::input('text','abreviation',null,array('placeholder'=>"Abreviacion de Tipo de Ingresos",'maxlength'=>'7','class'=>'form-control'))!!}

        </label>
        <small class="error-message red-message">{{$errors->first('name')}}</small>
    </div>
    <div  class="col-lg-3 col-md-3">
        <label>Departamento de la Iglesia</label>
        <select class="form-control select2" name="departament_id">
            <option value="">Selecciones un Departamento</option>
            @foreach($departaments As $departament)
            <option value="{{$departament->id}}">{{convertTitle($departament->name)}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-3 col-md-3">

        <div class="wrap">
            <form action="" class="formulario">
                <div class="radio">
                    <h2>Radio Buttons</h2>

                    <input type="radio" name="sexo" id="hombre">
                    <label for="hombre">Hombre</label>

                    <input type="radio" name="sexo" id="mujer">
                    <label for="mujer">Mujer</label>

                    <input type="radio" name="sexo" id="alien">
                    <label for="alien">Alien</label>
                </div>

                <div class="checkbox">
                    <h2>Checkboxines :D</h2>
                    <input type="checkbox" name="checkbox" id="checkbox1">
                    <label for="checkbox1">Checkboxin 1</label>

                    <input type="checkbox" name="checkbox2" id="checkbox2">
                    <label for="checkbox2">Checkboxin 2</label>
                </div>
            </form>
        </div>
    </div>
</div>
</br>
<div class="col-lg-3 col-md-3">

    <div class="large-12 columns text-center">
        <a href="{{route('typeFix-lista')}}" class="btn btn-default"><i class="fa fa-ban"></i>Regresar</a>
        <input type="submit" value="{{$action}}" class="btn btn-info radius " />
    </div>
</div>
{!! Form::close()!!}
@stop