<?php namespace SistemasAmigables\Entities;


class Bank extends Entity
{
    protected $timestamp;

    protected $fillable= ['name','balance','date','url','type','record_id','check_id','account_id','number'];

    public function getRules()
    {
        return ['record_id'=>'required' ,'balance'=>'required','date'=>'required','account_id'=>'required'];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }

    public function records()
    {
        return $this->belongsTo(Record::getClass(),'record_id','id');
    }
}
