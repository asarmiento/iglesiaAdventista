<?php

class TiposUser extends \Eloquent {

    protected $table = 'tipos_users';
    // Add your validation rules here
    public static $rules = [
        'name' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function User() {
        return $this->belongsTo('users');
    }

}
