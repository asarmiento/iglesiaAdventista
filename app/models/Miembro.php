<?php

class Miembro extends \Eloquent {

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'last' => 'required',
        'date_bautizmo' => 'required',
        'date_nacimiento' => 'required',
        'phone' => 'required',
        'celular' => 'required',
        'email' => 'required',
        'iglesias_id' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'last', 'date_bautizmo', 'date_nacimiento', 'phone', 'celular', 'email', 'iglesias_id'];

    public function Iglesia() {
        return $this->HasMany('iglesias');
    }

}
