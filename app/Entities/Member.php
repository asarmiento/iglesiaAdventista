<?php

namespace SistemasAmigables\Entities;



class Member extends Entity
{
    protected $timestamp;

    protected $fillable= ['name','last','bautizmoDate','birthdate','phone','cell','email','church_id'];

    public function getRules()
    {
        return [
            'name'    =>'required',
            'last'      =>'required',
            'church_id'    =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
