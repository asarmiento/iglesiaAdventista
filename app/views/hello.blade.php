@extends('template.main')

@section('container')
@parent
  <center><h3>Bienvenido {{ Auth::user()->name; }}</h3><br></center>
@stop