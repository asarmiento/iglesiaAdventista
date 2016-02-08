<?php

namespace SistemasAmigables\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class User extends Entity implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

   // use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email','typeUser_id', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function typeUsers() {
        return $this->belongsTo(TypeUser::getClass(), 'type_user_id', 'id');
    }

    public function tasks() {
        return $this->belongsToMany(Task::getClass())->withPivot('status', 'menu_id');
    }

    public function menus() {
        return $this->belongsToMany(Menu::getClass(), 'task_user')->withPivot('status', 'task_id')->orderBy('priority', 'asc')->orderBy('name', 'asc');
    }

    /* Relacion con la tabla schools */

    public function schools() {
        return $this->belongsToMany(School::getClass());
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        // TODO: Implement getEmailForPasswordReset() method.
    }

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }
}
