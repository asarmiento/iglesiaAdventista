<?php

class Departamento extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'saldo' => 'required',
        'iglesias_id' => 'required'
    ];
    protected $fillable = ['name', 'iglesias_id', 'saldo'];

     public function gasto() {
        return $this->belongsTo('Gasto','id','departamentos_id');
    }
    public function iglesia() {
        return $this->HasMany('Iglesia', 'id', 'iglesias_id');
    }

}
