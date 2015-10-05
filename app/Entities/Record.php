<?php

namespace SistemasAmigables\Entities;

use Illuminate\Database\Eloquent\Model;

class Record extends Entity
{
    protected $timestamp;

    protected $fillable= ['numbers','controlNumber','saturday','balance'];

    public function getRules()
    {
        return [
            'numbers'    =>'required',
            'controlNumber'      =>'required',
            'saturday'      =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
