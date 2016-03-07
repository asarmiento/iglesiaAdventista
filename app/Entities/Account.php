<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 05/01/16
 * Time: 08:08 PM
 */

namespace SistemasAmigables\Entities;


class Account extends Entity
{

    protected $fillable = ['code','name','initial_balance','debit_balance','credit_balance','balance'];

    public function getRules()
    {
        return ['code'=>'required','name'=>'required']; // TODO: Implement getRules() method.
    }



}