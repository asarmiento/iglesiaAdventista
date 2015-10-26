@extends('layouts.layouts')
@section('title')
Miembros
@stop

@section('title-form')
Lista Miembros
@stop

@section('content')
<div><a href="{{route('crear-miembro')}}"  class="button radius">Agregar</a></div>
<table>
    <thead>
        <tr> 
            <th>Nº</th>
            <th width="250">Nombre</th> 
            <th width="150">Telefono</th> 
            <th width="150">Celular</th> 
            <th width="150">Email</th> 
            <th width="50">Editar</th> 
            <th width="50">Eliminar</th> 
        </tr>
    </thead> 
    <tbody> 
         @foreach($members AS $member)
        <tr>
    <td></td>
    <td>{{$member->name}} {{$member->last}}</td>
    <td>{{$member->phone}}</td>
    <td>{{$member->celular}}</td>
    <td>{{$member->email}}</td>
    <td><a class="btn btn-warning" href="{{URL::action('MemberController@edit',$member->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
    <td><a class="btn btn-warning" href="{{URL::action('MemberController@destroy',$member->id)}}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
        @endforeach
    </tbody>
</table>
<div class="container">
    {{--$member->nextPageUrl() --}}
</div>
@stop