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
    /**************************************************
    * @Author: Anwar Sarmiento Ramos
    * @Email: asarmiento@sistemasamigables.com
    * @Create: 27/07/16 08:21 AM   @Update 0000-00-00
    ***************************************************
    * @Description: Con esta consultas recibimos el total
    * de la asociación segun el id del control interno
    *
    *
    * @Pasos:
    *
    *
    * @return amount
    ***************************************************/
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
    /**************************************************
    * @Author: Anwar Sarmiento Ramos
    * @Email: asarmiento@sistemasamigables.com
    * @Create: 27/07/16 08:27 AM   @Update 0000-00-00
    ***************************************************
    * @Description: Total de diezmos segun el id del
    *   control interno en un rango de fechas
    *
    *
    * @Pasos:
    *
    *
    * @return amount
    ***************************************************/
    public function diezmosRecord($id,$dateIn,$dateout){

        return $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','no')->where('association','si');
        })->where('record_id',$id)->whereBetween('date',[$dateIn,$dateout])->sum('balance');
    }
    /**************************************************
    * @Author: Anwar Sarmiento Ramos
    * @Email: asarmiento@sistemasamigables.com
    * @Create: 27/07/16 08:30 AM   @Update 0000-00-00
    ***************************************************
    * @Description:
    *
    *
    *
    * @Pasos:
    *
    *
    * @return
    ***************************************************/
    public function diezmos($dateIn,$dateout){

        return $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','no')->where('association','si');
        })->whereBetween('date',[$dateIn,$dateout])->sum('balance');
    }
    /**************************************************
    * @Author: Anwar Sarmiento Ramos
    * @Email: asarmiento@sistemasamigables.com
    * @Create: 27/07/16 08:30 AM   @Update 0000-00-00
    ***************************************************
    * @Description:
    *
    *
    *
    * @Pasos:
    *
    *
    * @return amount
    ***************************************************/
    public function ofrendaRecord($id,$dateIn,$dateout)
    {
        $ofrenda = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','si');
        })->where('record_id',$id)->whereBetween('date',[$dateIn,$dateout])->sum('balance');

        return ($ofrenda/5);
    }

    public function ofrenda($dateIn,$dateout)
    {
        $ofrenda = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','si');
        })->whereBetween('date',[$dateIn,$dateout])->sum('balance');

        return ($ofrenda/5);
    }
    /**************************************************
    * @Author: Anwar Sarmiento Ramos
    * @Email: asarmiento@sistemasamigables.com
    * @Create: 27/07/16 04:50 PM   @Update 0000-00-00
    ***************************************************
    * @Description:
    *
    *
    *
    * @Pasos:
    *
    *
    * @return
    ***************************************************/
    public function ofrendaLocal($dateIn,$dateout)
    {
        $ofrenda = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','si');
        })->whereBetween('date',[$dateIn,$dateout])->sum('balance');

        $ofrendaOther = $this->newQuery()->wherehas('typeIncomes',function($q){
            $q->where('part','no')->where('offering','si')->where('association','no');
        })->whereBetween('date',[$dateIn,$dateout])->sum('balance');

        return (($ofrenda/5)*3)+$ofrendaOther;
    }

    public function ofrendaTypeIncome($typeIncome,$date)
    {
        $ofrenda = $this->newQuery()->wherehas('typeIncomes',function($q) use ($typeIncome){
            $q->where('id',$typeIncome);
        })->whereBetween('date',[$date])->sum('balance');



        return $ofrenda;
    }
    public function incomeDateMember($member,$date){
        return $this->newQuery()->where('member_id',$member)->where('date',$date)->orderBy('id','ASC');
    }
}