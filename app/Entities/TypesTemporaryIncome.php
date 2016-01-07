<?php

namespace SistemasAmigables\Entities;


class TypesTemporaryIncome extends Entity
{
    protected $timestamp;

    protected $fillable= ['balance','name','church_id'];

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

    public function varExponses()
    {
        return $this->belongsToMany(Expense::getClass(),'expense_income','id','types_temporary_income_id')->withPivot('amount','type_fixed_income_id')->sum('expense_income.amount');
    }

    public function varIncomes()
    {
        return $this->belongsTo(Income::getClass(),'id','typesTemporaryIncome_id')->sum('balance');
    }
}
