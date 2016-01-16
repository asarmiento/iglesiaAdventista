<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/12/15
 * Time: 01:39 PM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Income;

class IncomeRepository extends BaseRepository
{
    /**
     * @var TypeIncomeRepository
     */
    private $TypeIncomeRepository;

    /**
     * IncomeRepository constructor.
     * @param TypeIncomeRepository $TypeIncomeRepository
     */
    public function __construct(
        TypeIncomeRepository $TypeIncomeRepository

    )
    {

        $this->TypeIncomeRepository = $TypeIncomeRepository;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new Income(); // TODO: Implement getModel() method.
    }



}