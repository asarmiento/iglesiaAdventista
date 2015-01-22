<?php

class Ingreso extends \Eloquent {
    use SoftDeletingTrait;
    // Add your validation rules here
    public static $rules = [
        'historial_id' => 'required',
        'num_sobre' => 'required',
        'imagen' => 'required',
        'date' => 'required',
        'monto' => 'required',
        'miembros_id' => 'required',
        'tipos_fijos_id' => 'required',
        'tipos_variables_id' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['historial_id', 'num_sobre', 'imagen', 'date', 'monto', 'miembros_id', 'tipos_fijos_id', 'tipos_variables_id'];

    public function miembro() {
        return $this->HasMany('Miembro','id','miembros_id');
    }

    public function tiposfijos() {
        return $this->HasMany('TiposFijo','id','tipos_fijos_id');
    }

    public function tiposvariables() {
        return $this->HasMany('TiposVariable','id','tipos_variables_id');
    }
    public function historial() {
        return $this->HasMany('Historial','id','historial_id');
    }

}
