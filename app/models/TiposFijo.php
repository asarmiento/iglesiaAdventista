<?php

class TiposFijo extends \Eloquent {

    protected $table = 'tipos_fijos';
    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'saldo' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'saldo'];

    public function Ingresos() {
        return $this->belongsTo('ingresos');
    }

}
