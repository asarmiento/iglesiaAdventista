@extends('layouts.layouts')
@section('title')
Miembros
@stop

@section('title-form')
Lista Miembros
@stop

@section('content')

<div class="panel-body">
    <div class="btn btn-info"><a href="{{route('crear-miembro')}}"  class="button radius">Agregar</a></div>
    <div class="panel-body">
        <table id="table_member" class="table-bordered">
            <thead>
            <tr>
                <th>Nº</th>
                <th width="250">Nombre</th>
                <th width="150">Telefono</th>
                <th width="150">Celular</th>
                <th width="150">Email</th>
                <th width="50">Editar</th>
                <th width="50">Ver</th>
                <th width="50">Info. D & O</th>
            </tr>
            </thead>
            <tbody>
            @foreach($members AS $key=>$member)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$member->name}} {{$member->last}}</td>
                    <td>{{$member->phone}}</td>
                    <td>{{$member->celular}}</td>
                    <td>{{$member->email}}</td>
                    <td class="text-center"><a href="{{URL::action('MemberController@edit',$member->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td class="text-center"><a  href="{{URL::action('MemberController@view',$member->token)}}"><span class="fa fa-street-view"></span></a></td>
                    <td class="text-center"><a  href="{{URL::action('MemberController@viewInd',$member->token)}}"><span class="fa fa-street-view"></span></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop