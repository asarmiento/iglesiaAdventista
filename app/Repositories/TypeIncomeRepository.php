<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/10/15
 * Time: 10:22 PM
 */

namespace SistemasAmigables\Repositories;


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


}
