@extends('template.base')
    @section('styles')
        @parent
        {{ HTML::style('css/styles.css'); }}
    @stop

@section('content')
    <center><h1><span class="glyphicon glyphicon-log-in"></span>&nbsp;Login</h1></center>
        <div class="container principal">
            {{-- Preguntamos si hay algún mensaje de error y si hay lo mostramos  --}}

            @if(Session::has('mensaje_error'))
                {{ Session::get('mensaje_error') }}
            @endif

            <br><br>
           {{ Form::open(array('url' => '/login', 'action'=>'URL::action("AuthController@postLogin")', 'method'=>'post')) }}
            <div class="form-group">
                <label for="username">{{ Form::label('usuario', 'Usuario:') }} </label><br>
                {{ Form::text('username', Input::old('username'), array('class'=>'form-control')); }} <br><br>
            </div>
            <div class="form-group">
                <label for="password">{{ Form::label('contraseña', 'Contraseña:') }} </label><br>
                {{ Form::password('password', array('class'=>'form-control')); }} <br><br>
            </div>
            <div class="form-group">
                {{ Form::label('lblRememberme', 'Recordar contraseña') }}
                {{ Form::checkbox('rememberme', true) }} <br><br>
                <center>{{ Form::submit('    Entrar    ', array('class'=>'btn btn-primary')) }}</center>
            </div>
            {{ Form::close() }}
        </div>
@stop