<?php

namespace SistemasAmigables\Entities;



class Record extends Entity
{
    protected $timestamp;

    protected $fillable= ['numbers','controlNumber','saturday','balance','rows','token'];

    public function getRules()
    {
        return [
            'rows'       =>'required',
            'numbers'       =>'required',
            'controlNumber' =>'required',
            'balance'      =>'required',
            'saturday'      =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }


    public function incomes()
    {
        return $this->hasMany(Income::getClass());
    }

    public function banks()
    {
        return $this->belongsToMany(Bank::getClass());
    }
}
