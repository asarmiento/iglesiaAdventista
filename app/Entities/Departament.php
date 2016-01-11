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

    public function incomes()
    {
        return $this->hasMany(Income::getClass(),'departament_id','id');
    }

    public function expenses()
    {
        return $this->belongsTo(Expense::getClass(),'id','departament_id');
    }
    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
