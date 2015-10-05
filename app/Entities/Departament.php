<?php

namespace SistemasAmigables\Entities;


class Departament extends Entity
{
    protected $timestamp;

    protected $fillable= ['budget','name','balance','church_id'];

    public function getRules()
    {
        return [
            'budget'    =>'required',
            'name'      =>'required',
            'balance'   =>'required',
            'church_id' =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
