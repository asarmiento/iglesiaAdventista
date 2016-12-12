<?php
/**
 * Created by PhpStorm.
 * User: Amwar
 * Date: 27/11/2016
 * Time: 06:43 PM
 */

namespace SistemasAmigables\Entities;


class OtherIncome extends Entity
{

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    public function typeIncomes()
    {
        return $this->belongsTo(TypeIncome::getClass(),'type_income_id','id');
    }
}