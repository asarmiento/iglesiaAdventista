<?php

namespace SistemasAmigables\Entities;



class Income extends Entity
{
    protected $timestamp;

    protected $fillable= ['numberOf','url','image','date','balance','record_id','member_id','typeFixedIncome_id','typesTemporaryIncome_id','token'];

    public function getRules()
    {
        return [
            'numberOf'    =>'required',
            'date'      =>'required',
            'balance'    =>'required',
            'record_id' =>'required',
            'token' =>'required',
            'member_id' =>'required'
        ];
    }

    public function getExist()
    {
        // TODO: Implement getExist() method.
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function members()
    {
        return $this->belongsTo(Member::getClass(),'member_id','id');
    }

    public function twoWhere($data,$id,$data1,$id1)
    {
        return $this->where($data,$id)->where($data1,$id1)->sum('balance');
    }

    public function oneWhere($data,$id)
    {
        return $this->where($data,$id)->sum('balance');
    }
}
