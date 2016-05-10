@extends('layouts.layouts')
@section('title')
Informes Semanales
@stop

@section('title-form')
Lista Informes Semanales
@stop

@section('content')
    <div class="panel">

<div>@include('partials/errors')</div>
<div>@include('partials/message')</div>
<form action="{{route('periodos-store')}}" method="post" role="form" class="form-inline">
<table class="table">
        <tbody >
        {{csrf_field()}}
        <tr>
            <th><label>Periodo Actual:</label></th>
            <td><input name="oldPeriod"   type="text" value="{{$periods['old']}}"></td>
            <th><label>Nuevo Periodo:</label></th>
            <td><input name="newPeriod"  type="text" value="{{$periods['new']}}"></td>
        </tr>
    <tr>
        <td></td>
        <td><a href="{{url()}}/iglesia/periodos"  class="btn btn-info radius">Regresar</a></td>
        <td class="center-block" colspan="6"><input type="submit" value="Cambiar" class="btn btn-info radius" /></td>
    </tr>
    </tbody>
</table>
</form>

    </div>
@stop