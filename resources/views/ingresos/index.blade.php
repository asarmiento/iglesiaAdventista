@extends('layouts.layouts')
@section('title')
Ingresos
@stop

@section('title-form')
Lista Ingresos
@stop

@section('content')
<div><a href="{{url()}}/ingresos/create"  class="button radius">Crear</a></div>
<table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Miembros</th> 
            <th width="150">Diezmo</th> 
            <th width="150">Ofrenda</th> 
            <th width="150">Materiales E.S.</th> 
            <th width="150">Proyecto Especial</th> 
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
  @foreach($ingresos AS $ingreso)
        <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><a class="btn btn-warning" href="{{URL::action('IglesiasController@edit',$ingreso->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="{{URL::action('IglesiasController@destroy',$ingreso->id)}}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop