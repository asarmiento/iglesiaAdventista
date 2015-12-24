<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/12/15
 * Time: 08:25 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Departament;

class DepartamentRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Departament();// TODO: Implement getModel() method.
    }
}