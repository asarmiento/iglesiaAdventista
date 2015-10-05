<?php namespace SistemasAmigables\Entities;


class Bank extends Entity
{
    protected $timestamp;

    protected $fillable= ['name','balance','date','url','type','record_id','check_id'];

    public function getRules()
    {
        return ['name'=>'required' ,'balance'=>'required','date'=>'required','type'=>'required'];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }
}
