@extends('template.main')

@section('container')
  @if($errors->has())
      @foreach($errors->all() as $error)
          <p>{{$error}}</p>
      @endforeach
  @endif
    <center><h1><span class="glyphicon glyphicon-user"></span>&nbsp;Agregar Usuario</h1></center><br>
  <form role="form" action="{{URL::action('UserController@postAddUser')}}" method="POST">
    <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" class="form-control" name="name" placeholder="Nombre">
      </div>
    <div class="form-group">
        <label for="lastname">Apellido:</label>
        <input type="text" class="form-control" name="lastname" placeholder="Apellido">
      </div>
        <div class="form-group">
        <label for="username">Usuario:</label>
        <input type="text" class="form-control" name="username" placeholder="Usuario">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" placeholder="Email">
      </div>
      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" class="form-control" name="password" placeholder="Contraseña">
      </div>
       <div class="form-group">
        <label for="password_confirmed">Confirmar Contraseña:</label>
        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Contraseña">
      </div><br>
      <center>
      <button type="submit" class="btn btn-primary">Registrarme</button>
       {{ HTML::link('/', 'Cancelar', array('class'=>'btn btn-danger')) }}
       </center>
       <br>
  </form>
  @if(Session::has('message'))
      {{ Session::get('message') }}
  @endif
@stop