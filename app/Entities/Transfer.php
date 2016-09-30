<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 13/05/16
 * Time: 12:29 AM
 */

namespace SistemasAmigables\Entities;


class Transfer extends Entity
{
    protected $fillable = ['date','departament_id','detail','vote','amount','type'];

    public function getRules()
    {
       return [
           'date'=>'required',
           'departament_id'=>'required',
           'detail'=>'required',
           'vote'=>'required',
           'type'=>'required',
           'amount'=>'required'
            ]; // TODO: Implement getRules() method.
    }


    public function departaments()
    {
        return $this->belongsTo(Departament::getClass(),'departament_id','id');
    }
}