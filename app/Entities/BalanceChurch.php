<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 03/05/16
 * Time: 03:22 PM
 */

namespace SistemasAmigables\Entities;


class BalanceChurch extends Entity
{
    protected $table = 'balance_church';

    protected $fillable = ['period_id','date','amount'];

    public function getRules()
    {
        return ['period_id'=>'required','date'=>'required','amount'=>'required'];// TODO: Implement getRules() method.
    }

    public function periods()
    {
        return $this->belongsTo(Period::getClass(),'period_id','id');
    }
}