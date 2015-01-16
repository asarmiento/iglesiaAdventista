<?php

class Cheque extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'numero' => 'required',
        'name' => 'required',
        'date' => 'required',
        'detalle' => 'required',
        'monto' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['numero', 'name', 'date', 'detalle', 'monto'];

    public function banco() {

        return $this->belongsTo('Banco','id','cheques_id');
    }

    public function gasto() {

        return $this->belongsTo('Gasto','id','gastos_id');
    }

}
