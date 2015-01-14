@extends('layouts.layouts')
@section('title')
Informes Semanales
@stop

@section('title-form')
Lista Informes Semanales
@stop

@section('content')
<div><a href="{{url()}}/informes"  class="button radius">Regresar</a></div>
{{Form::open(array('route' => 'informes.store', 'method' => 'POST'),array('role'=>'form','class'=>'form-inline'))}}

<div class="row">
    <div class="large-12 columns text-center">
        <input type="submit" value="Agregar" class="button radius" />
    </div>
</div>
{{Form::close()}}
@stop