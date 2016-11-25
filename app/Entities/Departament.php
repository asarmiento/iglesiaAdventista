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

    public function typeExpenses()
    {
        return $this->belongsTo(TypeExpense::getClass(),'id','departament_id');
    }
    public function typeIncomes()
    {
        return $this->belongsTo(TypeIncome::getClass(),'id','departament_id');
    }
    public function typeIncomeWhere()
    {
        return $this->belongsTo(TypeIncome::getClass(),'id','departament_id')->where('base','si');
    }
    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
