@extends('layouts.layouts')
@section('title')
{{$action}} Ingresos
@stop

@section('title-form')
Formulario {{$action}} Ingresos
@stop

@section('content') 
{{Form::model($ingresos,$form_data,array('role'=>'form','class'=>'form-inline'))}}
<div class="row">
    <div class="large-4 columns">
        <label class="">Numero Informe: {{$informes->numero}}</label>
    </div>
    <div class="large-4 columns">
        <label class="">Fecha: {{$informes->sabado}}</label>
    </div>
    <div class="large-4 columns">
        <label class="">Saldo Disponible: {{number_format($informes->saldo)}}
        </label>
    </div>
</div>
<div class="row">
    <table>
        <thead>
            <tr>
                <th>Miembro</th> 
                @foreach($fijos AS $fijo)
                <th>{{$fijo->name}}</th>
                @endforeach
                @foreach($variables AS $variable)
                <th>{{$variable->name}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{Form::input('text','',null,array('placeholder'=>'Buscar Miembro','size'=>30,'style'=>'height:30px'))}}</td>
                @foreach($fijos AS $fijo)
                <td>{{Form::input('text','',null,array('placeholder'=>'0.00','size'=>5,'style'=>'height:30px'))}}</td>
                @endforeach
                @foreach($variables AS $variable)
                <td>{{Form::input('text','',null,array('placeholder'=>'0.00','size'=>5,'style'=>'height:30px'))}}</td>
                @endforeach
                <td><a><span class="glyphicon glyphicon-check"></span></a></td>
            </tr>
            <tr>
                <td>Anwar Sarmiento</td>
                <td>10000</td>
                <td>10000</td>
                <td>3000</td>
                <td>7000</td>
                <td>20000</td>
                <td><a><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
        </tbody>
    </table>

</div>

        </label>
        <small class="error-message red-message">{{$errors->first('iglesias_id')}}</small>
    </div>
</div>

</br>
<div class="row">
    <div class="large-12 columns text-center">
        <input type="submit" value="{{$action}}" class="button radius" />
    </div>
</div>
{{Form::close()}}
@stop