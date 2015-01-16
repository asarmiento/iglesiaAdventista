<?php

class Cheque extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'numero' => 'required',
        'name' => 'required',
        'date' => 'required',
        'detalle' => 'required',
        'monto' => 'required',
        'departamentos_id' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['numero', 'name', 'date', 'detalle', 'monto', 'departamentos_id'];

    public function banco() {

        return $this->belongsTo('Banco');
    }

    public function Departamentos() {

        $this->HasMany('departamento');
    }

}
