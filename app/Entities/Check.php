<?php

namespace SistemasAmigables\Entities;


class Check extends Entity
{
    protected $timestamp;

    protected $fillable= ['number','name','date','type','detail','balance','church_id','account_id'];

    public function getRules()
    {
        return [
            'number'    =>'required',
            'name'      =>'required',
            'date'      =>'required',
            'balance'    =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
    public function accounts()
    {
        return $this->belongsToMany(Account::getClass(),'account_check')->withPivot('balance');
    }
    public function departaments()
    {
        return $this->belongsTo(Departament::getClass(),'departament_id','id');
    }

    public function expenses()
    {
        return $this->belongsTo(Expense::getClass(),'id','check_id');
    }
}
