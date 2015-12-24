@extends('layouts.layouts')
@section('title')
Ingresos
@stop

@section('title-form')
Lista Ingresos
@stop

@section('content')
<div><a href=""  class="button radius">Crear</a></div>
<table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Miembros</th> 
            <th width="150">Diezmo</th> 
            <th width="150">Ofrenda</th> 
            <th width="150">Materiales E.S.</th> 
            <th width="150">Proyecto Especial</th> 
        </tr>
    </thead> 
    <tbody> 
  @foreach($incomes AS $income)
        <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop