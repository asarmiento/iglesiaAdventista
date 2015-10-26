@extends('layouts.layouts')
@section('title')
 Ingresos
@stop

@section('title-form')
Formulario  Ingresos
@stop

@section('content')
    <div>@include('partials/errors')</div>
<form method="post" action="{{route('incomes-store')}}" role='form' class='form-inline'>
<div class="row">
    <div class="large-4 columns">
        <label class="">Numero Informe: {{$incomes->controlNumber}}</label>
        <input name="tokenControlNumber" type="hidden" value="{{$incomes->_token}}">
    </div>
    <div class="large-4 columns">
        <label class="">Fecha: {{$incomes->saturday}}</label>
        <input name="_token" type="hidden" value="{{csrf_token()}}">
    </div>
    <div class="large-4 columns">
        <label class="">Saldo Disponible: {{number_format($incomes->balance)}}
        </label>
    </div>
</div>
<div class="row">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Numero Sobre</th>
                <th>Miembro</th>
                @foreach($fixeds AS $fixed)
                <th>{{$fixed->name}}</th>
                @endforeach
                @foreach($temporaries AS $temporary)
                <th>{{$temporary->name}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
          <?php for($i=1;$i<=$incomes->rows;$i++): ?>
            <tr style="margin: 2px">
                <td>{{$i}}</td>
                <td style="margin: 4px"><input type="text" placeholder="Numero Sobre" name="numberAbout-{{$i}}" style="height:30px; margin: 4px" size="10"></td>
                <td style="margin: 4px">
                    <select  name="members-{{$i}}" style="height:40px; margin: 4px" size="30">
                        <option selected value="">Seleccione un Miembro</option>
                        @foreach($members AS $member)
                            <option value="{{$member->_token}}">{{$member->name.' '.$member->last}}</option>
                        @endforeach
                    </select></td>
                @foreach($fixeds AS $fixed)
                <td style="margin: 4px"><input type="text" placeholder="0.00" name="fixeds-{{$i}}-{{$fixed->id}}" style="height:30px; margin: 4px" size="10"></td>
                @endforeach
                @foreach($temporaries AS $temporary)
                <td style="margin: 4px"><input type="text" placeholder="0.00" name="temporary-{{$i}}-{{$temporary->id}}" style="height:30px; margin: 4px" size="5"></td>
                @endforeach
                <td></td>
            </tr>
          <?php endfor; ?>
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
        <input type="submit" value="Registrar" class="button radius" />
    </div>
</div>
</form>
@stop