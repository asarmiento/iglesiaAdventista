<?php

class TypeUser extends \Eloquent {
    protected $table='type_user';
    // Add your validation rules here
	public static $rules = [
		 'name' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name'];

}