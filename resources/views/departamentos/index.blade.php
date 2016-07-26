@extends('layouts.layouts')
@section('title')
Departamentos
@stop

@section('title-form')
Lista Departamentos
@stop

@section('content')
    <div class="text-center">
        <h2>Lista Departamentos de la Iglesia</h2>
    </div>
<div class="btn btn-info"><a href="{{route('create-depart')}}"  class="button radius">Nuevo</a></div>
<div class="panel-body">

<table id="table_depart" class="table table-bordered">
    <thead>
        <tr> 
            <th>Nº</th>
            <th>Departamento</th>
            <th>Porcentaje</th>
            <th>Saldo Actual</th>
        </tr>
    </thead> 
    <tbody>
    <?php
            $porcent=0;
            $budget=0;
    ?>
        @foreach($departaments AS $key=>$departament)
        <tr class="text-center">
            <td>{{$key+1}}</td>
            <td>{{$departament->name}}</td>
            <td>{{number_format($departament->budget*100,2)}}%</td>
            @if($departament->balance < 0)
                <td style="color: #ac1212"> ₡ {{number_format($departament->balance,2)}}</td>
            @else
                <td> ₡ {{number_format($departament->balance,2)}}</td>
            @endif
        </tr>
            <?php
                    if($departament->type=='iglesia'):
                        $porcent+=$departament->budget;
                        $budget+=$departament->balance;
                    endif;
            ?>
        @endforeach

    </tbody>
</table>
    <table class="table-condensed">
        <tbody>
        <tr class="color-green">
            <td></td>
            <td>Total</td>
            <td>Porcentaje: {{number_format($porcent*100,2)}}%</td>
            <td>Total del Presupuesto: {{number_format($budget,2)}}</td>
       </tr>
        </tbody>
    </table>
</div>
@stop