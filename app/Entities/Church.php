<?php

namespace SistemasAmigables\Entities;


class Church extends Entity
{
    protected $timestamp;

    protected $fillable= ['address','name','phone'];

    public function getRules()
    {
        return [
            'address'    =>'required',
            'name'      =>'required',
            'phone'      =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }


}
