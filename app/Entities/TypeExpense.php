<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/01/16
 * Time: 01:30 PM
 */

namespace SistemasAmigables\Entities;


class TypeExpense extends Entity
{

    protected $fillable = ['name','church_id','departament_id'];
    public function getRules()
    {
       return [
           'name'=>'required',
            'departament_id'=>'required'
       ]; // TODO: Implement getRules() method.
    }

    public function departament()
    {
        return $this->belongsTo(Departament::getClass());
    }

    public function expenses()
    {
        return $this->belongsTo(Expense::getClass(),'expenses_id','id');
    }

    public function sumExpenses()
    {
        return $this->belongsTo(Expense::getClass(),'expenses_id','id');
    }
}