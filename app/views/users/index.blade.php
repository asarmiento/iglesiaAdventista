@extends('template.main')

@section('container')
	<center><h1><span class="glyphicon glyphicon-user"></span>&nbsp;Ver usuarios</h1></center>
		<div class="table-responsive">
		<table class="table table-stripped">
        <thead>
         <tr>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Email</th>
          <th></th>
          <th></th>
         </tr>
        </thead>
        <tbody>
         @foreach ($users as $user)
          <tr>
           <td>{{ $user->name }}</td>
           <td>{{ $user->lastname }}</td>
           <td>{{ $user->email }}</td>
			<td><a class="btn btn-danger" href="{{URL::action('UserController@getDelete',$user->id)}}"><span class="glyphicon glyphicon-trash"></span></a></td>
			<td><a class="btn btn-warning" href="{{URL::action('UserController@getEdit',$user->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
          </tr>
         @endforeach
        </tbody>
       </table><br>
            @if(Session::has('message'))
               {{ Session::get('message') }}
            @endif
       <br><br>
       <center>
       {{ HTML::link('/', 'Inicio', array('class'=>'btn btn-primary')) }}
       </center>
    </div>
@stop