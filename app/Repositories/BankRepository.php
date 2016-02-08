<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/02/16
 * Time: 08:05 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Bank;

class BankRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Bank();// TODO: Implement getModel() method.
    }
}