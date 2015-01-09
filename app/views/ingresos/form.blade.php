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
        <label class="">Fecha
            {{Form::input('text','date',null,array('placeholder'=>"fecha",'id'=>'date','readonly'=>"readonly"))}}
        </label>
        <small class="error-message red-message">{{$errors->first('name')}}</small>
    </div>
    <div class="large-4 columns">
        <label class="">Nº Informe 
            {{Form::input('text','saldo','00001',array('readonly'=>"readonly",'style'=>'color:red; size:20px;'))}}
        </label>
        <small class="error-message red-message">{{$errors->first('saldo')}}</small>
    </div>
    <div class="large-4 columns">
        <label class="">Iglesia
            {{Form::input('text','saldo','',array('readonly'=>"readonly"))}}
        </label>
        <small class="error-message red-message">{{$errors->first('iglesias_id')}}</small>
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
            </tr>
            @foreach($miembros AS $miembro)
            <tr>
                <td>{{$miembro->name}}{{$miembro->last}}</td>
                @foreach($fijos AS $fijo)
                <td>{{Form::input('text','',null,array('placeholder'=>'0.00','size'=>5,'style'=>'height:30px'))}}</td>
                @endforeach
                @foreach($variables AS $variable)
                <td>{{Form::input('text','',null,array('placeholder'=>'0.00','size'=>5,'style'=>'height:30px'))}}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container">
        {{$miembros->links()}}
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