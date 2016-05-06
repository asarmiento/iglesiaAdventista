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

    public function amountCampo($id)
    {
        $ofrenda = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','si');
        })->where('record_id',$id)->sum('balance');

        $ofrendas = ($ofrenda/5)*2;

        $diezmos = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','no')->where('association','si');
        })->where('record_id',$id)->sum('balance');

        $total = $ofrendas+$diezmos;

        return $total;
    }

    public function Campo($dateIn,$dateout)
    {
        $ofrenda = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','si');
        })->whereBetween('date',[$dateIn,$dateout])->sum('balance');

        $ofrendas = ($ofrenda/5)*2;

        $diezmos = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','no')->where('association','si');
        })->whereBetween('date',[$dateIn,$dateout])->sum('balance');

        $total = $ofrendas+$diezmos;

        return $total;
    }

    public function campoRecord($id,$dateIn,$dateout)
    {
        $ofrenda = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','si');
        })->where('record_id',$id)->whereBetween('date',[$dateIn,$dateout])->sum('balance');

        $ofrendas = ($ofrenda/5)*2;

        $diezmos = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','no')->where('association','si');
        })->where('record_id',$id)->whereBetween('date',[$dateIn,$dateout])->sum('balance');

        $total = $ofrendas+$diezmos;

        return $total;
    }

    public function diezmosRecord($id,$dateIn,$dateout){

        return $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','no')->where('association','si');
        })->where('record_id',$id)->whereBetween('date',[$dateIn,$dateout])->sum('balance');
    }

    public function ofrendaRecord($id,$dateIn,$dateout)
    {
        $ofrenda = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','si');
        })->where('record_id',$id)->whereBetween('date',[$dateIn,$dateout])->sum('balance');

        return ($ofrenda/5);
    }
}