<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 26/05/16
 * Time: 11:20 PM
 */
?>
@extends('layouts.layouts')
@section('title')
    Miembros
@stop

@section('title-form')
    Lista Miembros
@stop

@section('content')

    <div class="panel-body">
        <div class="btn btn-info"><a href="{{route('periodos-create')}}"  class="button radius">Cambiar de Periodo</a></div>
        <div class="panel-body">
            <form target="_blank" action="{{route('pdf-auditoria')}}" method="post" >
                <div class="row">
                    <label>Seleccione el Año</label>
                    <select name="year" class="form-control">
                        @foreach($periods AS $key=>$period)
                        <option value="{{$period->year}}">{{$period->year}}</option>
                        @endforeach
                    </select>
                    {{csrf_field()}}
                </div>
                <div class="row">
                    <input type="submit" value="Generar" class="btn btn-primary">
                </div>
            </form>

        </div>
    </div>

@stop