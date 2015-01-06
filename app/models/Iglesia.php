<?php

class Iglesia extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'misions_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name','phone','address','misions_id'];

}