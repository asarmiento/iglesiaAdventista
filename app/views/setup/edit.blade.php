@extends('template.main')
@section('head')
<meta name="description" content="Pagina inicio">
<meta name="author" content="Anwar Sarmiento">
<meta name="keyword" content="palabras, clave">     
<title><?php echo utf8_encode('Editar Configuración'); ?></title>
@stop
@section('title')
<h1 class="text-lowercase"><?php echo utf8_encode('Editar de Configuración'); ?></h1>
@stop
@section('container') 
<div class="table-responsive">
       {{ Form::open(array(
            'action'=>'SetupController@postEdit',
            'method'=>'POST',
            'role'=>'form',
            'class'=>'form-inline'
            ))}}
    @foreach($resultado as $datos)
    <table>
        <tbody>
            <tr>
                <th>Cedula: </th>
                <td>{{Form::input('text','cedula',$datos->cedula,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('cedula')}}</td>
            </tr>
            <tr>
                <th>Junta:</th>
                <td>{{Form::input('text','junta',$datos->junta,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('junta')}}</td>
            </tr>
            <tr>
                <th>Nombre:</th>
                <td>{{Form::input('text','nombre',$datos->nombre,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('nombre')}}</td>
            </tr>
            <tr>
                <th>Circuito:</th>
                <td>{{Form::input('text','circuito',$datos->circuito,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('circuito')}}</td>
            </tr>
            <tr>
                <th>Codigo:</th>
                <td>{{Form::input('text','codigo',$datos->codigo,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('codigo')}}</td>
            </tr>
            <tr>
                <th>Fuente Financiamiento:</th>
                <td>{{Form::input('text','fuente',$datos->fuente_financiamiento,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('fuente')}}</td>
            </tr>
            <tr>
                <th>Periodo:</th>
                <td>{{Form::input('text','periodo',$datos->periodo,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('periodo')}}</td>
            </tr>
            <tr>
                <th>Director:</th>
                <td>{{Form::input('text','director',$datos->director,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('director')}}</td>
            </tr>
            <tr>
                <th>Presidente:</th>
                <td>{{Form::input('text','presidente',$datos->presidente,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('presidente')}}</td>
            </tr>
            <tr>
                <th>Secretario(a):</th>
                <td>{{Form::input('text','secretario',$datos->secretario,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('secretario')}}</td>
            </tr>
             <tr>
                <th>Contador(a):</th>
                <td>{{Form::input('text','contador',$datos->contador,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('contador')}}</td>
            </tr>
            <tr>
                <th>Linea 1:</th>
                <td>{{Form::input('text','linea1',$datos->linea1,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('linea1')}}</td>
            </tr>
             <tr>
                <th>Linea 2:</th>
                <td>{{Form::input('text','linea2',$datos->linea2,array('class'=>'form-control','size'=>60))}}</td>
                <td>{{$errors->first('linea2')}}</td>
            </tr>
        </tbody>
    </table>
 

    {{Form::input('hidden','id',$datos->id,array('class'=>'form-control'))}}
    {{Form::input('submit',null,'Actualizar',array('class'=>'btn btn-primary'))}}
    <div class="bg-danger" id="_name">{{$errors->first('buscar')}}</div>

{{Form::close()}}  
    @endforeach
</div>
@stop