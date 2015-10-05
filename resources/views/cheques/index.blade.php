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
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
  @foreach($cheques AS $cheque) 
        <tr>
    <td></td>
    <td>{{$cheque->name}}</td>
    <td>{{$cheque->date}}</td>
    <td>{{$cheque->monto}}</td>
    <td>{{$cheque->Departamentos->name}}</td>
    <td><a class="btn btn-warning" href="{{URL::action('IglesiasController@edit',$cheque->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="{{URL::action('IglesiasController@destroy',$cheque->id)}}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
@stop