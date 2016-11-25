<?php

namespace SistemasAmigables\Entities;


class TypeIncome extends Entity
{
    protected $timestamp;

    protected $fillable= ['balance','name', 'church_id','departament_id','abreviation'];

    public function getRules()
    {
        return [
            'name'                =>'required',
            'abreviation'      =>'required',
            'departament_id'      =>'required',
            'church_id' =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }

    public function fixExponses()
    {
        return $this->belongsToMany(Expense::getClass(),'expense_income','id','type_income_id')->sum('expense_income.amount');
    }
    public function typeExpenses()
    {
        return $this->belongsToMany(TypeExpense::getClass());
    }
    public function fixIncomes()
    {
        return $this->belongsTo(Income::getClass(),'id','type_income_id');
    }
    public function departament()
    {
        return $this->belongsTo(Departament::getClass());
    }
    public function incomes()
    {
        return $this->hasMany(Income::getClass());
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::getClass(),'expense_income')->withPivot('amount','types_temporary_income_id');
    }
}
