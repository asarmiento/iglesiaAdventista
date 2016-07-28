<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 08/07/16
 * Time: 06:09 PM
 -->
@extends('layouts.layouts')
@section('title')
    Editar Tipos de Ingresos
@stop

@section('title-form')
    Formulario Editar Tipos de Ingresos
@stop

@section('content')
    {!! Form::open(['route' => array('update-typeFixs', $tiposfijo->id), 'method' => 'POST','role'=>'form','class'=>'form-inline'])!!}
    <div class="form-group">
        <div class="col-md-4 col-lg-4 ">
            <label class="">Nombre Tipo de Ingresos</label>
                {!! Form::input('text','name',$tiposfijo->name,array('placeholder'=>"Tipos de Ingresos",'class'=>'form-control'))!!}
                {!! Form::input('hidden','church_id',$iglesia[0],array('placeholder'=>""))!!}
        </div>
        <div  class="col-md-4 col-lg-4 ">
            <label>Abreviación para informe Semanal</label>
                {!! Form::input('text','abreviation',$tiposfijo->abreviation,array('placeholder'=>"Abreviacion de Tipo de Ingresos",'maxlength'=>'7','class'=>'form-control'))!!}
            <small class="error-message red-message">{{$errors->first('name')}}</small>
        </div>
        <div  class="col-md-4 col-lg-4 ">
            <label>Departamentos de iglesia</label>
            <select class="form-control select2" name="departament_id">
                <option value="{{$tiposfijo->departament->id}}">{{$tiposfijo->departament->name}}</option>
                @foreach($departaments As $departament)
                    <option value="{{$departament->id}}">{{convertTitle($departament->name)}}</option>
                @endforeach
            </select>
        </div>
        </br>
        <div  class="col-md-7 col-lg-7 text-center">


                <a href="{{route('typeFix-lista')}}" class="btn btn-default"><i class="fa fa-ban"></i>Regresar</a>
                <input type="submit" value="Actualizar" class="btn btn-info radius " />

        </div>
    </div>

    {!! Form::close()!!}
@stop