<?php

class Historial extends \Eloquent {
	  // Add your validation rules here
    public static $rules = [
        'sabado' => 'required'
    ];
    // Don't forget to fill this array
    protected $fillable = ['sabado'];
}