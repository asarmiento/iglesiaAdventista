<?php

namespace SistemasAmigables\Entities;


class Check extends Entity
{
    protected $timestamp;

    protected $fillable= ['number','name','date','detail','amount','church_id'];

    public function getRules()
    {
        return [
            'number'    =>'required',
            'name'      =>'required',
            'date'      =>'required',
            'amount'    =>'required',
            'church_id' =>'required',
            'detail'    =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
