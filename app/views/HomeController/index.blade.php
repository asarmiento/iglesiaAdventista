@extends('layouts.session')
@section('head')
<meta name='title' content='Login'>
<meta name='description' content='Login'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='noindex,nofollow'>    
<title>Página Incio</title>
@stop
@section('content') 

{{ Form::open(array(
            'action'=>'HomeController@index',
            'method'=>'POST',
            'role'=>'form',
            'class'=>'form-signin'
            ))}}
            <h2 class="form-signin-heading">Iniciar Sección</h2>
                
            <div class="form-group">
              {{Form::label('Email: ')}}
              {{Form::input('text','email',null,array('class'=>'form-control',"placeholder"=>"Correo Electronico","required","autofocus"))}}
            </div>
            <div class="form-group">
              {{Form::label('Contraseña: ')}}
              {{Form::input('password','password',null,array('class'=>'form-control',"placeholder"=>"Contraseña","required"))}}
            </div>
            <div class="form-group">
              {{Form::label('Recordar sesión: ')}}
              {{Form::input('checkbox','remember','On',array("class"=>"checkbox"))}}
            </div>
            <div class="form-group">
              {{Form::input('hidden','_token',csrf_token())}}
              {{Form::input('submit',null,'Iniciar Sesión',array('class'=>'btn btn-lg btn-primary btn-block'))}}
            </div>
{{Form::close()}}
@stop 