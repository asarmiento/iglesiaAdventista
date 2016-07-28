<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 13/05/16
 * Time: 12:30 AM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Transfer;

class TransfersRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new Transfer(); // TODO: Implement getModel() method.
    }
}