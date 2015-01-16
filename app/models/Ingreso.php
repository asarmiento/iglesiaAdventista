<?php

class Ingreso extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'historial_id' => 'required',
        'num_sobre' => 'required',
        'num_control' => 'required',
        'date' => 'required',
        'monto' => 'required',
        'miembros_id' => 'required',
        'tipos_fijos_id' => 'required',
        'tipos_variables_id' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['historial_id', 'num_sobre', 'num_control', 'date', 'monto', 'miembros_id', 'tipos_fijos_id', 'tipos_variables_id'];

    public function Miembro() {
        return $this->HasMany('mienbros');
    }

    public function TiposFijos() {
        return $this->HasMany('tipos_fijos');
    }

    public function TiposVariables() {
        return $this->HasMany('tipos_variables');
    }
    public function Historial() {
        return $this->HasMany('historials');
    }

}
