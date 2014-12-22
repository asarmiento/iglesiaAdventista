@extends('layouts.content')

@section('head')
<title>Registro</title>
<meta name='description' content='Registro'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='noindex,nofollow'>
@stop

@section('content')

<h1>Formulario de Registro</h1>

{{Session::get("message")}}

{{Form::open(array(
            "method" => "POST",
            "action" => "HomeController@register",
            "role" => "form",
            ))}}
 
            <div class="form-group">
                {{Form::label("Nombre:")}}
                {{Form::input("text", "user", Input::old('user'), array("class" => "form-control"))}}
                <div class="bg-danger">{{$errors->first('user')}}</div>
            </div>           
            
            <div class="form-group">
                {{Form::label("Email:")}}
                {{Form::input("email", "email", Input::old('email'), array("class" => "form-control"))}}
                <div class="bg-danger">{{$errors->first('email')}}</div>
            </div> 
            
            <div class="form-group">
                {{Form::label("Password:")}}
                {{Form::input("password", "password", Input::old('password'), array("class" => "form-control"))}}
                <div class="bg-danger">{{$errors->first('password')}}</div>
            </div>
            
            <div class="form-group">
                {{Form::label("Repetir password:")}}
                {{Form::input("password", "repetir_password", Input::old('repetir_password'), array("class" => "form-control"))}}
                <div class="bg-danger">{{$errors->first('repetir_password')}}</div>
            </div>
            
            <div class="form-group">
                {{Form::label("Aceptar los términos:")}}
                {{Form::input("checkbox", "terminos", "On")}}
                <div class="bg-danger">{{$errors->first('terminos')}}</div>
            </div>
            
            <div class="form-group">
                {{Form::input('hidden','registrar')}}
                {{Form::input("hidden", "_token", csrf_token())}}
                {{Form::input("submit", null, "Registrarme", array("class" => "btn btn-primary"))}}
            </div>
            
{{Form::close()}}

@stop