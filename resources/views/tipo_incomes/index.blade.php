@extends('layouts.layouts')
@section('title')
Tipos de Ingresos
@stop
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
@stop
@section('title-form')
Lista Tipos de ingresos
@stop

@section('content')
    <div class="panel-body">
        <div class="text-center"><h1>Cuentas de Ingresos</h1></div>
        <div class="btn btn-info"><a href="{{route('crear-typeFix')}}"  class="button radius">Nuevo</a></div>
        <div class="panel-body">
        <table id="type_fix" class="table-bordered">
            <thead>
                <tr>
                    <th width="200">Nº</th>
                    <th width="150">Departamento</th>
                    <th width="150">Nombre</th>
                    <th width="150">Abreviación</th>
                    <th width="150">Saldo</th>
                    <th width="150">Estado</th>
                    <th width="150">Editar</th>
               </tr>
            </thead>
            <tbody>
            <?php $total=0;?>
                  @foreach($tipoincomes AS $key=>$tipoincome)
                <tr>
            <td>{{$key+1}}</td>
                    <td>{{$tipoincome->departament->name}}</td>
                    <td>{{$tipoincome->name}}</td>
                    <td>{{$tipoincome->abreviation}}</td>
                    <td>{{number_format($tipoincome->balance,2)}}</td>
                    @if($tipoincome->status == 'activo')
                    <td><a href="{{route('desactivar-tipo-ingreso',$tipoincome->id)}}"><span class="label label-success">{{ $tipoincome->status }}</span></a></td>
                    @else
                    <td><a  href="{{route('activar-tipo-ingreso',$tipoincome->id)}}"><span class="label label-danger">{{ $tipoincome->status }}</span></a></td>
                    @endif
                    <td class="text-center"><a  href="{{route('typeFix-edit',$tipoincome->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
            </tr><?php $total +=$tipoincome->balance;?>
                @endforeach
            </tbody>
        </table>
        </div>
        <div>Total de Tipos de Ingresos{{number_format($total,2)}}</div>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('js/lib/dataTables.bootstrap.js') }}"></script>
@stop
