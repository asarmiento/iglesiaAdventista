@extends('layouts.layouts')
@section('title')
Cheques
@stop

@section('title-form')
Lista Cheques
@stop

@section('content')
<table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="200">Nombre</th> 
            <th width="150">Fecha</th> 
            <th width="150">Monto</th> 
            <th width="150">Departamento</th> 
            <th width="150">Tipo Fijo</th> 
            <th width="150">Tipo Variable</th> 
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 

    </tbody>
</table>
@stop