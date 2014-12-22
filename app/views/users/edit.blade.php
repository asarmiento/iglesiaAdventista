@extends('template.main')

@section('container')
    <center><h1><span class="glyphicon glyphicon-edit"></span>&nbsp;Editar Usuario</h1></center>
    @if($errors->has())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif

    <form role="form" action="{{URL::action('UserController@postEditUser',$user->id)}}" method="POST">
      <div class="form-group">
          <label for="name">Nombre:</label>
          <input type="text" class="form-control" name="name" placeholder="Nombre" value="{{$user->name}}">
        </div>
      <div class="form-group">
          <label for="lastname">Apellido:</label>
          <input type="text" class="form-control" name="lastname" placeholder="Apellido" value="{{$user->lastname}}">
        </div>
          <div class="form-group">
          <label for="username">Usuario:</label>
          <input type="text" class="form-control" name="username" placeholder="User" value="{{$user->username}}">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" name="email" placeholder="Email" value="{{$user->email}}">
        </div>
        <div class="form-group">
          <label for="password">Contraseña:</label>
          <input type="password" class="form-control" name="password" placeholder="Contraseña">
        </div>
         <div class="form-group">
          <label for="password_confirmed">Confirmar Contraseña:</label>
          <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Contraseña">
        </div>
        <center>
        <button type="submit" class="btn btn-sucess">Guardar</button>
         {{ HTML::link('users/', 'Cancelar', array('class'=>'btn btn-danger')) }}
         </center>
    </form>
    @if(Session::has('message'))
        {{ Session::get('message') }}
    @endif
@stop