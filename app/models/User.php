<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public $validator;

    public function isValid($data)
    {
        $rules = array(
            'email'     => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password'  => 'required|confirmed'
        );

        //Si el usuario existe
          if($this->exists)
          {
               //Evitamos que la regla "unique" tom en centa el email del usario actual
               $rules['email'] .= ',email,'.$this->id;
               $rules['username'] .=',username,'.$this->id;
               $rules['password'] = '';
          }

        $validator = Validator::make($data, $rules);

        if ($validator->passes())
        {
            return true;
        }

        $this->validator = $validator;

        return false;
    }


}
