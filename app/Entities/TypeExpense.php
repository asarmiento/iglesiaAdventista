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

    public function departaments()
    {
        return $this->hasMany(Departament::getClass(),'id','departament_id');
    }
}