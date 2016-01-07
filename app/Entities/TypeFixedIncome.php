<?php

namespace SistemasAmigables\Entities;


class TypeFixedIncome extends Entity
{
    protected $timestamp;

    protected $fillable= ['balance','name', 'church_id'];

    public function getRules()
    {
        return [
            'name'      =>'required',
            'church_id' =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }

    public function fixExponses()
    {
        return $this->belongsToMany(Expense::getClass(),'expense_income','id','typeFixedIncome_id')->sum('expense_income.amount');
    }

    public function fixIncomes()
    {
        return $this->belongsTo(Income::getClass(),'id','typeFixedIncome_id')->sum('balance');
    }
}
