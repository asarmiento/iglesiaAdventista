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
        <h1>Informe de Movimientos de los Gastos</h1>
        <div class="btn btn-info"><a href="{{route('index-gasto')}}"  class="button radius">Regresar</a></div>
        <form action="{{route('lista-gastos-pdf')}}" target="_blank" method="post">
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
                    <option value="1-1">Todos los Gastos</option>
                    @foreach($typeExpenses AS $type)
                        <option value="{{$type->id}}">{{ucwords(strtolower($type->name))}}</option>
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
    <div class="panel-body">
        <h1>Informe de Movimientos de los Gastos x Departamentos</h1>
        <form action="{{route('lista-gastos-pdf')}}" target="_blank" method="post">
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
                    <select name="departament" class="form-control">
                        <option value="1-2">Todos los Departamentos</option>
                        @foreach($departaments AS $departament)
                            <option value="{{$departament->id}}">{{ucwords(strtolower($departament->name))}}</option>
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