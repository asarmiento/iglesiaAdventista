<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 03/03/16
 * Time: 08:56 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Campo;
use SistemasAmigables\Entities\DepositsLocalField;

class CampoRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new DepositsLocalField();// TODO: Implement getModel() method.
    }
}