<?php

namespace SistemasAmigables\Entities;


class TypesTemporaryIncome extends Entity
{
    protected $timestamp;

    protected $fillable= ['balance','name','church_id','departament_id'];

    public function getRules()
    {
        return [
            'name'      =>'required',
            'departament_id'      =>'required',
            'church_id' =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departaments()
    {
        return $this->hasMany(Departament::getClass(),'id','departament_id');
    }
    public function incomes()
    {
        return $this->belongsTo(Income::getClass(),'id','typesTemporaryIncome_id');
    }
    public function varExponses()
    {
        return $this->belongsToMany(Expense::getClass(),'expense_income','id','types_temporary_income_id')->sum('expense_income.amount');
    }

    public function varIncomes()
    {
        return $this->belongsTo(Income::getClass(),'id','typesTemporaryIncome_id')->sum('balance');
    }
}
