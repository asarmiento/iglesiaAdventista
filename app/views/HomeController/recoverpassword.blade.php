@extends('layouts.content')

@section('head')
<title>Recuperar password</title>
<meta name='description' content='Recuperar password'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='noindex,nofollow'>
@stop

@section('content')

<h1>Recuperar password:</h1>

{{Session::get("message")}}

{{Form::open(array(
            "method" => "POST",
            "action" => "HomeController@recoverpassword",
            "role" => "form",
            ))}}
 
            <div class="form-group">
                {{Form::label("Email:")}}
                {{Form::input("email", "email", null, array("class" => "form-control"))}}
                <div class="bg-danger">{{$errors->first('email')}}</div>
            </div> 
            
            <div class="form-group">
                {{Form::input("hidden", "_token", csrf_token())}}
                {{Form::input("submit", null, "Recuperar password", array("class" => "btn btn-primary"))}}
            </div>
            
{{Form::close()}}

@stop




