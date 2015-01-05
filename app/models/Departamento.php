<?php

class Departamento extends \Eloquent {
        
     // Add your validation rules here
	public static $rules = [
		 'name' => 'required',
             'saldo' => 'required',
            'iglesias_id' => 'required'
	];
	protected $fillable = ['name','iglesias_id','saldo'];
}