<?php

namespace SistemasAmigables\Entities;


class TypeUser extends Entity
{
    protected $table = 'typeUsers';

    protected $fillable = ['name'];
    //
    public function getRules()
    {
        return ['name'=>'required'];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }

    public function users() {
        return $this->belongsTo(User::getClass());
    }
}
