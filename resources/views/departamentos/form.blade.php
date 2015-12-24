@extends('layouts.layouts')
@section('title')
{{$action}} Departamentos
@stop

@section('title-form')
Formulario {{$action}} Departamentos
@stop

@section('content')
{!! Form::model($departamentos,$form_data,array('role'=>'form','class'=>'form-inline'))!!}
<table class="row">
    <tr class="large-4 columns">
        <label class="">Nombre Departamentos
            {!! Form::input('text','name',null,array('placeholder'=>"Departamentos"))!!}
        </label>
        <small class="error-message red-message">{{$errors->first('name')}}</small>
    </tr>
    <tr class="large-4 columns">
        <label class="">Presupuesto
            {!! Form::input('text','saldo',null,array('placeholder'=>"Saldo Disponible"))!!}
        </label>
        <small class="error-message red-message">{{$errors->first('saldo')}}</small>
    </tr>
    <tr>
        {!! Form::input('hidden','church_id',$church,array('placeholder'=>"Iglesia"))!!}

    </tr>
<tr class="text-center">
    <td colspan="4">
        <input type="submit" value="{{$action}}" class="btn btn-info radius" />
    </td>
 </tr>
</table>
{!! Form::close()!!}
@stop