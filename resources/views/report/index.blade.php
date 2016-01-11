@extends('layouts.layouts')
@section('title')
    Informes Semanales
@stop

@section('title-form')
    Lista Informes Semanales
@stop

@section('content')
    <div class="panel panel-body">
        <form action="{{route('post-report')}}" method="post">
        <div class="col-sm-6 col-md-6">
            <label for="date">Fecha Inicial: </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                <input name="date" class="form-control" type="date" >
                {{csrf_field()}}
            </div>
        </div>

        <div class="col-sm-6 col-md-6">
            <div  class="input-group">
                <input type="submit" value="Buscar" class="btn btn-info radius" />
            </div>
        </div>
        </form>
    </div>
@stop