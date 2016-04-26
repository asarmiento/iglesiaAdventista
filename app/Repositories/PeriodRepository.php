<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 25/04/16
 * Time: 03:49 AM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Period;

class PeriodRepository extends BaseRepository

{

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new Period();// TODO: Implement getModel() method.
    }
}