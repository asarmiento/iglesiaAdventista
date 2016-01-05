<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/10/15
 * Time: 10:22 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\TypeFixedIncome;

class TypeFixedRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new TypeFixedIncome();
    }


}