<?php

namespace SistemasAmigables\Entities;


class TypesTemporaryIncome extends Entity
{
    protected $timestamp;

    protected $fillable= ['balance','name','church_id'];

    public function getRules()
    {
        return [
            'balance'    =>'required',
            'name'      =>'required',
            'church_id' =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
