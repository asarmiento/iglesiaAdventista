<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/01/16
 * Time: 01:40 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\TypeExpense;

class TypeExpenseRepository extends  BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new TypeExpense(); // TODO: Implement getModel() method.
    }

    public function updateAmountExpense($id,$amount){
        $credit = $amount + $this->newQuery()->where('id',$id)->sum('balance');

        return $this->newQuery()->where('id',$id)
            ->update(['balance'=>$credit]);
    }
}