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

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
