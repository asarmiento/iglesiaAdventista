<?php

class Iglesia extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'phone', 'address'];

    public function Users() {
        return $this->belongsTo('users');
    }
     public function miembro() {
        return $this->belongsTo('Miembro');
    }
    public function departamento() {
        return $this->belongsTo('Departamento');
    }
}
