<?php

namespace SistemasAmigables\Entities;


class TypeIncome extends Entity
{
    protected $timestamp;

    protected $fillable= ['balance','name', 'church_id','departament_id'];

    public function getRules()
    {
        return [
            'name'                =>'required',
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

    public function fixIncomes()
    {
        return $this->belongsTo(Income::getClass(),'id','type_income_id');
    }
    public function departaments()
    {
        return $this->hasMany(Departament::getClass(),'id','departament_id');
    }
    public function incomes()
    {
        return $this->belongsTo(Income::getClass(),'id','type_income_id');
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::getClass(),'expense_income')->withPivot('amount','types_temporary_income_id');
    }
}
