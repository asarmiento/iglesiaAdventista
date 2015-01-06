<?php

class TiposVariable extends \Eloquent {
    protected $table='tipos_variales';
    // Add your validation rules here
	public static $rules = [
		 'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name'];

}