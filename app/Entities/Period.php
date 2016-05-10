<?php

namespace SistemasAmigables\Entities;

use Illuminate\Database\Eloquent\Model;

class Period extends Entity
{
    protected $fillable = ['month','year','church_id','token'];

    public function getRules()
    {
       return ['month'=>'required','year'=>'required','church_id'=>'required','token'=>'required']; // TODO: Implement getRules() method.
    }
}
