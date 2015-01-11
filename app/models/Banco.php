<?php

class Banco extends \Eloquent {
	  // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'saldo' => 'required',
        'tipo' => 'required',
        'historial_id' => 'required',
        'cheques_id' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'saldo','tipo','historial_id','cheques_id'];
    
    public function Cheques() {

        $this->HasMany('cheques');
    }
    
    public function historial() {

        $this->HasOne('historial');
    }
}