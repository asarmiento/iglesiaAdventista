<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 05/01/16
 * Time: 05:50 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Expense;

class ExpensesRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Expense();// TODO: Implement getModel() method.
    }
}