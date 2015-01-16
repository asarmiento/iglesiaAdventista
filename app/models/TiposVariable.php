<?php

class TiposVariable extends \Eloquent {

    protected $table = 'tipos_variables';
    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'saldo' => 'required',
        'iglesias_id'=>'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'saldo','iglesias_id'];

    public function ingreso() {
        return $this->belongsTo('Ingreso');
    }

    public function iglesia() {
        return $this->HasMany('Iglesia', 'id', 'iglesias_id');
    }

}
