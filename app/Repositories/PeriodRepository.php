<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 25/04/16
 * Time: 03:49 AM
 */

namespace SistemasAmigables\Repositories;


use SistemasAmigables\Entities\Period;

class PeriodRepository extends BaseRepository

{

    /**
     * @return mixed
     */
    public function getModel()
    {
       return new Period();// TODO: Implement getModel() method.
    }

    public function before($period)
    {

        $month = $period->month - 1;
        $year = $period->year;
       
        if(strlen ($month) == 1 ):
            $month = '0'.$month;
        endif;

        if($period->month == 1 || $period->month == '01'):
            $month = 12;
            $year = $period->year-1;
        endif;




        $before= $this->newQuery()->where('month',$month)->where('year',$year)->get();

        if($before->count() == 0):
            return false;
        endif;

        return $before[0];
    }
}