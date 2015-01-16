<?php

class Banco extends \Eloquent {
	  // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'saldo' => 'required',
        'tipo' => 'required',
        'imagen' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'saldo','tipo','imagen','historial_id','cheques_id'];

    public function cheques() {

        return $this->HasOne('Cheque', 'id', 'cheques_id');
    }

    public function historial() {

        return $this->HasOne('Historial', 'id', 'historial_id');
    }
}
