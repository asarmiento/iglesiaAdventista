@extends('layouts.content')
@section('head')
<meta name="description" content="Pagina inicio">
        <meta name="author" content="Anwar Sarmiento">
   <meta name="keyword" content="palabras, clave">     
<title>Página Menú</title>
@stop
@section('title')
Estamos en la Pagina de Inicio
@stop

<br><br>



<br><br>
@section('bread')



    <li><a href="#">Home</a></li>
   <li><a href="#">Library</a></li>
   <li class="active">Data</li>
@stop




@section('content') 
<h1>Bienvenido {{Auth::user()->get()->user}}</h1>

 

<span class="label label-default">Catalogo</span>
<span class="label label-primary">Presupuesto</span>
<span class="label label-success">Proveedores</span>
<span class="label label-info">Planillas</span>
<span class="label label-warning">Bancos</span>
<span class="label label-danger">Configuración</span>

<br><br>
<button class="btn btn-primary" type="button">
  Agregar <span class="badge">+</span>
</button>



@stop