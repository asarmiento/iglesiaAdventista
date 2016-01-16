<?php

namespace SistemasAmigables\Entities;


class Expense extends Entity
{
    protected $timestamp;

    protected $fillable= ['invoiceNumber','invoiceDate','date','detail','amount','check_id','type_expense_id','imagen'];

    public function getRules()
    {
        return [
            'invoiceNumber'  =>'required',
            'invoiceDate'    =>'required',
            'date'           =>'required',
            'amount'         =>'required',
            'check_id'       =>'required',
            'type_expense_id' =>'required',
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
        return $this->belongsTo(TypeExpense::getClass(),'type_expense_id','id');
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
