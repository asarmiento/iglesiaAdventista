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
     * @var TypeFixedRepository
     */
    private $typeFixedRepository;

    /**
     * IncomeRepository constructor.
     * @param TypeFixedRepository $typeFixedRepository
     */
    public function __construct(
        TypeFixedRepository $typeFixedRepository

    )
    {

        $this->typeFixedRepository = $typeFixedRepository;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new Income(); // TODO: Implement getModel() method.
    }



}