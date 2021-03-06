<?php namespace SistemasAmigables\Entities;


class Bank extends Entity
{
    protected $timestamp;

    protected $fillable= ['name','balance','date','url','type','check_id','account_id','number'];

    public function getRules()
    {
        return ['balance'=>'required','date'=>'required','account_id'=>'required'];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }

    public function records()
    {
        return $this->belongsToMany(Record::getClass());
    }


}
