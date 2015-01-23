<?php

class Iglesia extends \Eloquent {
    use SoftDeletingTrait;
    protected $softDelete = true;
    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'phone', 'address'];

    public function user() {
        return $this->belongsTo('user','id','users_id');
    }
     public function miembro() {
        return $this->belongsTo('Miembro','id','iglesias_id');
    }
    public function departamento() {
        return $this->belongsTo('Departamento','id','departamentos_id');
    }
}
