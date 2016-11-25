<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/10/15
 * Time: 10:22 PM
 */

namespace SistemasAmigables\Repositories;


use Log;
use SistemasAmigables\Entities\TypeIncome;

class TypeIncomeRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new TypeIncome();
    }
	
	public function sumaTotal($id)
	{
		$this->newQuery()->where('id',$id)->sum('amount');
	}

    public function name($data,$name)
    {
        return $this->newQuery()->where($data,$name)->get();
    }

    public function ofrendaAsoc()
    {
        return $this->newQuery()->where('offering','si')->Where('part','no')->where('association','si')->get();
    }

    public function updateBalanceAll($data,$amount)
    {
        if($data->association == 'si' && $data->offering == 'no' && $data->part == 'no'):
            $balance= $this->oneWhere('id',$data->id);
            $newbalance= $balance[0]->balance + $amount;
            $this->newQuery()->where('id',$data->id)->update(['balance'=>$newbalance]);
        elseif($data->association == 'si' && $data->offering == 'si' && $data->part == 'si'):
            $balance= $this->newQuery()->where('id',$data->id)->sum('balance');
            $newbalance= $balance + ($amount*0.4);
            $this->newQuery()->where('id',$data->id)->update(['balance'=>$newbalance]);
        elseif($data->association=='no' && $data->offering == 'si' && $data->part == 'no'):
           $balance= $this->oneWhere('id',$data->id);
            $newbalance= $balance[0]->balance + $amount;
            $this->newQuery()->where('id',$data->id)->update(['balance'=>$newbalance]);
        elseif($data->association=='no' && $data->offering == 'no' && $data->part == 'no'):
            $balance= $this->oneWhere('id',$data->id);
            $newbalance= $balance[0]->balance + $amount;
            $this->newQuery()->where('id',$data->id)->update(['balance'=>$newbalance]);
        endif;
    }
}
