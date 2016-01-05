<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 09/10/15
 * Time: 04:47 PM
 */

namespace SistemasAmigables\Repositories;



use SistemasAmigables\Entities\TypesTemporaryIncome;

class TypeTemporaryIncomeRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new TypesTemporaryIncome(); // TODO: Implement getModel() method.
    }


}