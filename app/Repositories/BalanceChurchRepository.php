<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 03/05/16
 * Time: 03:26 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\BalanceChurch;

class BalanceChurchRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new BalanceChurch();// TODO: Implement getModel() method.
    }

    public function saldoInitial($period)
    {
        $initial = $this->newQuery()->where('period_id',$period)->get();

        return $initial[0];
    }
}