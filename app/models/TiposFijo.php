<?php

class TiposFijo extends \Eloquent {

    protected $table = 'tipos_fijos';
    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'saldo' => 'required',
        'iglesias_id'=>'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'saldo','iglesias_id'];

    public function ingreso() {
        return $this->belongsTo('Ingreso','id','tipos_fijos_id');
    }

    public function iglesia() {
        return $this->HasMany('Iglesia', 'id', 'iglesias_id');
    }

}
