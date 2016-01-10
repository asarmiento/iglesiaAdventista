@extends('layouts.layouts')
@section('title')
    Miembros
@stop

@section('title-form')
    Lista Miembros
@stop

@section('content')

    <div class="panel-body">
        <div class="btn btn-info"><a href="{{route('members-lista')}}"  class="button radius">Regresar</a></div>
        <div class="list-group">
            <div><h2>{{$miembro->completo()}}</h2></div>
        </div>
        @if($miembro->incomes)
        @foreach($fixes AS $fix)
        <div class="col-md-3 col-lg3">
            <label>{{$fix->name}} Del Año: {{number_format($miembro->incomes->twoWhere('typeFixedIncome_id',$fix->id,'member_id',$miembro->id))}}</label>
        </div>
        @endforeach
        @foreach($temporals AS $temporal)
            <div class="col-md-3 col-lg3">
                <label>{{$temporal->name}} Del Año: {{number_format($miembro->incomes->twoWhere('typesTemporaryIncome_id',$temporal->id,'member_id',$miembro->id))}}</label>
            </div>
        @endforeach
        <div>
            <label>Total Del Año: {{number_format($miembro->incomes->oneWhere('typesTemporaryIncome_id',$temporal->id)) }} </label>
        </div>
        @else
        <div>No tiene Registros</div>
        @endif
    </div>
@stop