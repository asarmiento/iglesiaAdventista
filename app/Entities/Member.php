<?php

namespace SistemasAmigables\Entities;

use Illuminate\Database\Eloquent\Model;

class Member extends Entity
{
    protected $timestamp;

    protected $fillable= ['name','last','bautizmoDate','birthdate','phone','cell','email'];

    public function getRules()
    {
        return [
            'name'    =>'required',
            'last'      =>'required',
            'bautizmoDate'      =>'required',
            'birthdate'    =>'required',
            'cell' =>'required',
            'church_id'    =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
