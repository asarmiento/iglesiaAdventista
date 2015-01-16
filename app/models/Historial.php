<?php

class Historial extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'sabado' => 'required',
        'numero' => 'required',
        'num_control'=>'required',
        'saldo' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['numero', 'sabado','num_control', 'saldo'];

    public function ingreso() {
        return $this->belongsTo('Ingreso');
    }

    public function banco() {
        return $this->belongsTo('Banco');
    }

    public function lastId() {
        $lastId = Historial::orderBy('id', 'desc')->first();
        if ($lastId == null) {
            return 0;
        }
        return $lastId->id;
    }

}
