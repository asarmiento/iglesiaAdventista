<!--
 * Created by PhpStorm.
 * User: anwar
 * Date: 29/07/16
 * Time: 11:45 AM
-->
@extends('layouts.layouts')
@section('title')
     Miembros
@stop

@section('title-form')
    Formulario  Miembros
@stop

@section('content')
    <div class="panel">
        <div>@include('partials/errors')</div>
        <form method="POST" action="{{route('crear-members')}}" accept-charset="UTF-8" role='form' class='form-inline'>

            <table class="table-condensed">

                <tr>
                    <th>
                        <label class="">Nombre Miembro</label>
                    </th>
                    <td>
                        <select name="member_id" class="form-control select2">
                            @foreach($members AS $member)
                                <option value="{{$member->token}}">{{($member->completo())}}</option>
                            @endforeach
                        </select>
                    </td>
                    <th>
                        <label>Tipo de Gasto</label>
                    </th>
                    <td>
                        <select name="type_expense_id" class="form-control select2">
                            @foreach($typeExpenses AS $typeExpense)
                                <option value="{{$typeExpense->token}}">{{($typeExpense->name)}}</option>
                            @endforeach
                        </select>
                    </td>
                    <th>
                        <label>Monto</label>
                    </th>
                    <td>
                        <input name="amount">
                    </td>

                </tr>
                <tr class="media-middle text-center">
                    <td colspan="7">
                        <input type="submit" value="Guardar" class="btn btn-info radius" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
@stop