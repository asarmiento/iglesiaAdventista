<?php namespace SistemasAmigables\Repositories;


/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/10/15
 * Time: 12:43 PM
 */
use SistemasAmigables\Entities\Record;

class RecordRepository extends BaseRepository
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new Record();
    }
}