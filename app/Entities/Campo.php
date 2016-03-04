<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 03/03/16
 * Time: 08:15 PM
 */

namespace SistemasAmigables\Entities;


class Campo extends Entity
{
    protected  $fillable  = ['check_id','record_id','date','number','amount'];

    public function getRules()
    {
       return ['check_id'=>'required','record_id'=>'required','date'=>'required','amount'=>'required']; // TODO: Implement getRules() method.
    }

    public function records()
    {
        return $this->belongsTo(Record::getClass(),'record_id');
    }

    public function checks()
    {
        return $this->belongsTo(Check::getClass(),'check_id');
    }
}