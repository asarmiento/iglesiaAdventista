<?php

namespace SistemasAmigables\Entities;


class Expense extends Entity
{
    protected $timestamp;

    protected $fillable= ['invoiceNumber','invoiceDate','date','detail','amount','check_id','departament_id','imagen'];

    public function getRules()
    {
        return [
            'invoiceNumber'  =>'required',
            'invoiceDate'    =>'required',
            'date'           =>'required',
            'amount'         =>'required',
            'check_id'       =>'required',
            'departament_id' =>'required',
            'detail'         =>'required'
        ];
    }

    public function departaments()
    {
        return $this->belongsTo(Departament::getClass(),'departament_id','id');
    }
    public function checks()
    {
        return $this->belongsTo(Check::getClass(),'check_id','id');
    }
    public function typeExpenses()
    {
        return $this->belongsToMany(TypeExpense::getClass(),'expense_typeExpense','type_expense_id','expense_id')->withPivot('balance');
    }

    public function expenseFixIncome()
    {
        return $this->belongsToMany(TypeFixedIncome::getClass(),'expense_income')->withPivot('amount','typesTemporaryIncome_id');
    }

    public function expenseVarIncome()
    {
        return $this->belongsToMany(TypesTemporaryIncome::getClass(),'expense_income')->withPivot('amount','typeFixedIncome_id');
    }

    public function suma()
    {
        return $this->sum('amount');
    }

    public function oneWhere($data,$id)
    {
        return $this->where($data,$id)->sum('amount');
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
