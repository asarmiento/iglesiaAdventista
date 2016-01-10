<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 05/01/16
 * Time: 08:10 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Account;

class AccountRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new Account(); // TODO: Implement getModel() method.
    }
}