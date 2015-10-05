<?php

namespace SistemasAmigables\Entities;


class Income extends Entity
{
    protected $timestamp;

    protected $fillable= ['numberOf','url','image','date','balance','record_id','member_id','typeFixedIncome_id','typesTemporaryIncome_id'];

    public function getRules()
    {
        return [
            'numberOf'    =>'required',
            'date'      =>'required',
            'date'      =>'required',
            'balance'    =>'required',
            'record_id' =>'required',
            'member_id' =>'required',
            'typeFixedIncome_id' =>'required',
            'typesTemporaryIncome_id'    =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
