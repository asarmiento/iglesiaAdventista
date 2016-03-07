<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 05/01/16
 * Time: 09:56 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Check;

class CheckRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Check();// TODO: Implement getModel() method.
    }


    public function totalOut($data,$sum)
    {
        return $this->newQuery()->where($data,$sum)->sum('balance');
    }
}