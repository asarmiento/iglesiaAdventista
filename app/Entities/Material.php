<?php

namespace SistemasAmigables\Entities;

use Illuminate\Database\Eloquent\Model;

class Material extends Entity
{
    //
    protected  $fillable = ['member_id','type_expense_id','period_id','date','amount'];

    public function getRules()
    {
        // TODO: Implement getRules() method.
    }
}
