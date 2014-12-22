@extends('template.main')
@section('head')
<meta name="description" content="Pagina inicio">
<meta name="author" content="Anwar Sarmiento">
<meta name="keyword" content="palabras, clave">     
<title><?php echo utf8_encode('Configuración'); ?></title>
@stop
@section('title')
<h1 class="text-lowercase"><?php echo utf8_encode('Datos de Configuración'); ?></h1>
@stop
@section('container') 
<div class="table-responsive">
    @foreach($resultado as $datos)
    <table>
        <tbody>
            <tr>
                <th>Cedula: </th>
                <td>{{$datos->cedula}}</td>
            </tr>
            <tr>
                <th>Junta:</th>
                <td>{{$datos->junta}}</td>
            </tr>
            <tr>
                <th>Nombre:</th>
                <td>{{$datos->nombre}}</td>
            </tr>
            <tr>
                <th>Circuito:</th>
                <td>{{$datos->circuito}}</td>
            </tr>
            <tr>
                <th>Codigo:</th>
                <td>{{$datos->codigo}}</td>
            </tr>
            <tr>
                <th>Fuente Financiamiento:</th>
                <td>{{$datos->fuente_financiamiento}}</td>
            </tr>
            <tr>
                <th>Periodo:</th>
                <td>{{$datos->periodo}}</td>
            </tr>
            <tr>
                <th>Director:</th>
                <td>{{$datos->director}}</td>
            </tr>
            <tr>
                <th>Presidente:</th>
                <td>{{$datos->presidente}}</td>
            </tr>
            <tr>
                <th>Secretario(a):</th>
                <td>{{$datos->secretario}}</td>
            </tr>
             <tr>
                <th>Contador(a):</th>
                <td>{{$datos->contador}}</td>
            </tr>
            <tr>
                <th>Linea 1:</th>
                <td>{{$datos->linea1}}</td>
            </tr>
             <tr>
                <th>Linea 2:</th>
                <td>{{$datos->linea2}}</td>
            </tr>
        </tbody>
    </table>
    {{ Form::open(array(
            'action'=>'SetupController@getEdit',
            'method'=>'GET',
            'role'=>'form',
            'class'=>'form-inline'
            ))}}

            <center>{{Form::input('hidden','id',$datos->id,array('class'=>'form-control'))}}</center>
    {{Form::input('submit',null,'Editar',array('class'=>'btn btn-primary'))}}
    <div class="bg-danger" id="_name">{{$errors->first('buscar')}}</div>

{{Form::close()}}  
    @endforeach
</div>
@stop