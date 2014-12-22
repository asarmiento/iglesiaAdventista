@extends('layouts.content')
@section('head')
<meta name="description" content="Pagina contacto">
<meta name="author" content="Anwar Sarmiento">
<meta name="keyword" content="palabras, clave">
<meta name="robots" content="All"> 
<script>
$(function(){
    function send_ajax(){
        $.ajax({
            url:'contacto',
            type: 'POST',
            data: $("#form").serialize(),
            success: function(datos){
                $("#_email, #_name, #_subject, #_msg").text('');
                if(datos.success==false){
                    $.each(datos.errors, function(index, value){
                       $("#_"+index).text(value); 
                    });
                }
                else{
                    document.getElementById('form').reset();
                    $("#mensaje").text('Mensaje enviado con éxito');
                    
                }
            }
        });
    }
    $("#btn").on('click',function(){
        send_ajax();
    });
});
</script>
<title>Página Menú</title>
@stop
@section('title')
Estamos en la Pagina de Contacto
@stop
@section('content') 
<h1>Formulario de Contacto</h1>
<div id="mensaje"  class='text-info'> {{$mensaje}}</div>
{{ Form::open(array(
            'action'=>'HomeController@contacto',
            'method'=>'POST',
            'role'=>'form',
            'id'=>'form'
            ))}}
            <div class="form-group">
              {{Form::label('Nombre: ')}}
              {{Form::input('text','name',Input::old('name'),array('class'=>'form-control'))}}
              <div class="bg-danger" id="_name">{{$errors->first('name')}}</div>
            </div>
            <div class="form-group">
              {{Form::label('Email: ')}}
              {{Form::input('text','email',Input::old('email'),array('class'=>'form-control'))}}
              <div class="bg-danger" id="_email">{{$errors->first('email')}}</div>
            </div>
            <div class="form-group">
              {{Form::label('Asunto: ')}}
              {{Form::input('text','subject',Input::old('subject'),array('class'=>'form-control'))}}
              <div class="bg-danger" id="_subject">{{$errors->first('subject')}}</div>
            </div>
            <div class="form-group">
              {{Form::label('Nombre: ')}}
              {{Form::textarea('msg',Input::old('msg'),array('class'=>'form-control'))}}
              <div class="bg-danger" id="_msg">{{$errors->first('msg')}}</div>
            </div>
            <div class="form-group">
              {{Form::input('hidden','contacto')}}
              {{Form::input('button',null,'Enviar',array('class'=>'btn btn-primary','id'=>'btn'))}}
            </div>
{{Form::close()}}
@stop