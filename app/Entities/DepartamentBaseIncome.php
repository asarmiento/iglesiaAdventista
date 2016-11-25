<?php
/**
 * Created by PhpStorm.
 * User: Amwar
 * Date: 25/11/2016
 * Time: 08:05 AM
 */

namespace SistemasAmigables\Entities;


class DepartamentBaseIncome extends Entity
{
    protected $fillable = ['date','type_income_id','amount'];

    public function getRules()
    {
       return ['date'=>'required','type_income_id'=>'required','amount'=>'required']; // TODO: Implement getRules() method.
    }
}