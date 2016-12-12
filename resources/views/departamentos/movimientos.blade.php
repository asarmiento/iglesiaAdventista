<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/04/16
 * Time: 01:11 PM
 -->
@extends('layouts.layouts')
@section('title')
    Cuentas Bancarias
@stop

@section('title-form')
    Formulario Estado de Cuenta
@stop

@section('content')
    <div>@include('partials/errors')</div>
    <div>@include('partials/message')</div>
    <div class="panel-body text-center">

    </div>
    <form target="_blank" action="{{route('date-post-depart')}}" method="post">
        <div class="row">
            <div class="col-md-7 col-lg-7">
                <label>Departamentos</label>
                <select name="departament" class="form-control">
                    <option value="1-2">Todos los Departamentos</option>
                    @foreach($departaments AS $departament)
                        <option value="{{$departament->id}}">{{ucwords(strtolower($departament->name))}}</option>
                    @endforeach
                </select>
                {{csrf_field()}}
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Fecha Inicial</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                    <select  name="dateIn" class="form-control" >
                        @foreach($periods AS $period)
                            <option value="{{$period->dateIn}}">{{$period->dateIn}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <label for="date">Fecha Final</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                    <select  name="dateOut" class="form-control" >
                        @foreach($periods AS $period)
                            <option value="{{$period->dateOut}}">{{$period->dateOut}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{csrf_field()}}
        </div>
        </br>
        <div class="row">
            <div class="large-12 columns text-center">
                <a href="{{route('index-depart')}}"  class="btn btn-default radius">Regresar</a>
                <input type="submit" value="Generar" class="btn btn-info radius" />
            </div>
        </div>
    </form>

@stop