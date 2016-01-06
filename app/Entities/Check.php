<?php

namespace SistemasAmigables\Entities;


class Check extends Entity
{
    protected $timestamp;

    protected $fillable= ['number','name','date','detail','amount','church_id','account_id'];

    public function getRules()
    {
        return [
            'number'    =>'required',
            'name'      =>'required',
            'date'      =>'required',
            'amount'    =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
    public function accounts()
    {
        return $this->belongsToMany(Account::getClass(),'account_check')->withPivot('amount');
    }
    public function departaments()
    {
        return $this->belongsTo(Departament::getClass(),'departament_id','id');
    }
}
