<?php

namespace SistemasAmigables\Entities;

use Illuminate\Database\Eloquent\Model;

class Task extends Entity
{
    protected $timestamp;

    protected $fillable = ['name'];
    //
    public function getRules()
    {
        return ['name' => 'required'];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }

    public function Users() {
        return $this->belongsToMany(User::getClass())->withPivot('status');
    }

    public function menus() {
        return $this->belongsToMany(Menu::getClass())->withPivot('status');
    }
}
