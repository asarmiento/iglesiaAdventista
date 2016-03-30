<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/03/16
 * Time: 10:34 AM
 */

namespace SistemasAmigables\Http\Controllers\Report;


use Anouar\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;

class InformeDieOfe extends Controller
{

    /**
     * @var MemberRepository
     */
    private $memberRepository;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var TypeExpenseRepository
     */
    private $typeExpenseRepository;
    /**
     * @var TypeIncomeRepository
     */
    private $typeIncomeRepository;

    public function __construct(
       MemberRepository $memberRepository,
       IncomeRepository $incomeRepository,
       TypeIncomeRepository $typeIncomeRepository
    )
    {

        $this->memberRepository = $memberRepository;
        $this->incomeRepository = $incomeRepository;
        $this->typeIncomeRepository = $typeIncomeRepository;
    }
    public function index(){
        $this->header();
        $year = Input::get('year');

        $pdf = Fpdf::Ln();

        if(Input::get('tipo') == 1):
            $this->diezmoOfrenda($year);
        else:
            $this->ofrendas($year);
        endif;

        Fpdf::Output('Informe-Semana.pdf','I');
        exit;
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-00-00
    |@Date Update: 2016-00-00
    |---------------------------------------------------------------------
    |@Description:
    |
    |
    |@Pasos:
    |
    |
    |
    |
    |
    |
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    public function ofrendas($year)
    {
        $pdf = Fpdf::SetFont('Arial','B',10);
        $pdf .= Fpdf::Cell(5,7,utf8_decode('N°'),1,0,'C');
        $pdf .= Fpdf::Cell(55,7,utf8_decode('Miembros'),1,0,'C');
        $ofrendas = $this->typeIncomeRepository->getModel()->where('offering','si')->get();
        foreach($ofrendas AS $ofrenda):
            $ofrend = $this->incomeRepository->getModel()
                ->where('type_income_id',$ofrenda->id)->whereBetween('date',[$year.'-01-01',$year.'-12-31'])->sum('balance');
            if($ofrend > 0):
            $pdf .= Fpdf::Cell(15,7,substr(utf8_decode($ofrenda->name),0,6),1,0,'C');
            endif;
        endforeach;
        $pdf .= Fpdf::Cell(20,7,utf8_decode('Total'),1,0,'C');
        $miembros = $this->memberRepository->getModel()->orderBy('name','ASC')->get();
        $pdf .= Fpdf::Ln();
        $i=0;
        foreach($miembros AS $miembro):
            $i++;
            $pdf = Fpdf::SetFont('Arial','B',8);
            $pdf .= Fpdf::Cell(5,7,$i,1,0,'L');
            $pdf .= Fpdf::Cell(55,7,substr(utf8_decode($miembro->name.' '.$miembro->last),0,35),1,0,'L');
            $total = 0;
            foreach($ofrendas AS $ofrenda):
                $ofrend = $this->incomeRepository->getModel()->where('member_id',$miembro->id)
                    ->where('type_income_id',$ofrenda->id)->whereBetween('date',[$year.'-01-01',$year.'-12-31'])->sum('balance');
                $total += $ofrend;
                $sumOfrenda = $this->incomeRepository->getModel()
                    ->where('type_income_id',$ofrenda->id)->whereBetween('date',[$year.'-01-01',$year.'-12-31'])->sum('balance');
                if($sumOfrenda > 0):
                    if($ofrend > 0):
                        $pdf .= Fpdf::Cell(15,7,number_format($ofrend),1,0,'C');
                    else:
                        $pdf .= Fpdf::Cell(15,7,number_format(0),1,0,'C');
                    endif;
                endif;
            endforeach;
            $pdf .= Fpdf::Cell(20,7,number_format($total),1,0,'C');

            $pdf .= Fpdf::Ln();
        endforeach;
    }
    public function diezmoOfrenda($year)
    {
        $pdf = Fpdf::Ln();
        $pdf = Fpdf::SetFont('Arial','B',10);
        $pdf .= Fpdf::Cell(55,7,utf8_decode('Miembros'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Ene'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Feb'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Mar'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Abr'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('May'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Jun'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Total'),1,1,'C');


        $pdf .= Fpdf::SetX(65);
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,1,'C');
        $miembros = $this->memberRepository->getModel()->orderBy('name','ASC')->get();
        $typeDie = $this->typeIncomeRepository->getModel()->where('name','Diezmos')->lists('id');
        $typeOfe = $this->typeIncomeRepository->getModel()->where('offering','si')->lists('id');

        $mes = ['01','02','03','04','05','06'];
        foreach($miembros AS $miembro):
            $totalDie=0;
            $totalOfe=0;

            $pdf = Fpdf::SetFont('Arial','B',8);
            $pdf .= Fpdf::Cell(55,7,substr(utf8_decode($miembro->name.' '.$miembro->last),0,35),1,0,'L');
            for($i=0;$i<count($mes);$i++):
                $diezmo = $this->incomeRepository->getModel()->where('member_id',$miembro->id)->where('type_income_id',$typeDie[0])->whereBetween('date',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('balance');
                $totalDie += $diezmo;
                $pdf .= Fpdf::Cell(15,7,number_format($diezmo),1,0,'C');
                $ofrenda = $this->incomeRepository->getModel()->where('member_id',$miembro->id)->whereIn('type_income_id',$typeOfe)->whereBetween('date',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('balance');
                $totalOfe += $ofrenda;
                $pdf .= Fpdf::Cell(15,7,number_format($ofrenda),1,0,'C');
            endfor;
            $pdf .= Fpdf::Cell(15,7,number_format($totalDie),1,0,'C');
            $pdf .= Fpdf::Cell(15,7,number_format($totalOfe),1,0,'C');
            $pdf .= Fpdf::Ln();
        endforeach;

        $pdf .= Fpdf::Ln();
        $pdf = Fpdf::SetFont('Arial','B',10);
        $pdf .= Fpdf::Cell(55,7,utf8_decode('Miembros'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Jul'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Ago'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Sep'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Oct'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Nov'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Dic'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Total'),1,1,'C');

        $pdf .= Fpdf::SetX(65);
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Diez'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ofre'),1,1,'C');

        $miembros = $this->memberRepository->getModel()->orderBy('name','ASC')->get();
        $typeDie = $this->typeIncomeRepository->getModel()->where('name','Diezmos')->lists('id');
        $typeOfe = $this->typeIncomeRepository->getModel()->where('offering','si')->lists('id');

        $mes = ['07','08','09','10','11','12'];
        foreach($miembros AS $miembro):
            $totalDie=0;
            $totalOfe=0;
            $pdf = Fpdf::SetFont('Arial','B',8);
            $pdf .= Fpdf::Cell(55,7,utf8_decode($miembro->name.' '.$miembro->last),1,0,'L');
            for($i=0;$i<count($mes);$i++):
                $diezmo = $this->incomeRepository->getModel()->where('member_id',$miembro->id)->where('type_income_id',$typeDie[0])->whereBetween('date',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('balance');
                $totalDie += $diezmo;
                $pdf .= Fpdf::Cell(15,7,number_format($diezmo),1,0,'C');
                $ofrenda = $this->incomeRepository->getModel()->where('member_id',$miembro->id)->whereIn('type_income_id',$typeOfe)->whereBetween('date',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('balance');
                $totalOfe += $ofrenda;
                $pdf .= Fpdf::Cell(15,7,number_format($ofrenda),1,0,'C');
            endfor;
            $pdf .= Fpdf::Cell(15,7,number_format($totalDie),1,0,'C');
            $pdf .= Fpdf::Cell(15,7,number_format($totalOfe),1,0,'C');
            $pdf .= Fpdf::Ln();
        endforeach;

        Fpdf::Output('Informe-Semana.pdf','I');
        exit;
    }
    public function header()
    {
        $pdf  = Fpdf::AddPage('L','letter');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Apartado 10113-1000 San José, Costa Rica'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Teléfonos: 2224-8311 Fax:2225-0665'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Informe de Diezmos y Ofrendas Iglesia de Quepos'),0,1,'C');
        return $pdf;
    }
}