<!--**
 * Created by PhpStorm.
 * User: anwar
 * Date: 22/03/16
 * Time: 07:39 PM
 -->
@extends('layouts.layouts')
@section('title')
    Miembros
@stop

@section('title-form')
    Lista Miembros
@stop

@section('content')

    <div class="panel-body">
        <div class="btn btn-info"><a href="{{route('members-lista')}}"  class="button radius">Regresar</a></div>
        <form action="{{route('lista-diezmo-pdf')}}" target="_blank" method="post">
        <div class="form-group">
            <div class="col-md-7 col-lg-7">
                <label>Año</label>
                <select name="year" class="form-control">
                   <option value="2015">2015</option>
                   <option value="2016">2016</option>
                </select>
                {{csrf_field()}}
            </div>
            <div class="col-md-7 col-lg-7">
                <label>Tipo de informe</label>
                <select name="tipo" class="form-control">
                    <option value="1">Diezmos y Ofrendas</option>
                    <option value="2">Ofrendas Detallada</option>
                    @foreach($typeIncome AS $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                {{csrf_field()}}
            </div>
            <div class="col-md-7 col-lg-7">
                <input type="submit" class="btn btn-primary">
            </div>
       </div>
        </form>
    </div>
@stop