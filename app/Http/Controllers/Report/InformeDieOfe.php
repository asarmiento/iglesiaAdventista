<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 23/03/16
 * Time: 10:34 AM
 */

namespace SistemasAmigables\Http\Controllers\Report;


use Anouar\Fpdf\Facades\Fpdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Entities\OtherIncome;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\PeriodRepository;
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
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;
    /**
     * @var PeriodRepository
     */
    private $periodRepository;

    /**
     * InformeDieOfe constructor.
     * @param MemberRepository $memberRepository
     * @param IncomeRepository $incomeRepository
     * @param TypeIncomeRepository $typeIncomeRepository
     * @param DepartamentRepository $departamentRepository
     * @param PeriodRepository $periodRepository
     */
    public function __construct(
       MemberRepository $memberRepository,
       IncomeRepository $incomeRepository,
       TypeIncomeRepository $typeIncomeRepository,
        DepartamentRepository $departamentRepository,
        PeriodRepository $periodRepository
    )
    {

        $this->memberRepository = $memberRepository;
        $this->incomeRepository = $incomeRepository;
        $this->typeIncomeRepository = $typeIncomeRepository;
        $this->departamentRepository = $departamentRepository;
        $this->periodRepository = $periodRepository;
    }
    public function index(){
         $year = Input::get('year');

        $pdf = Fpdf::Ln();

        if(Input::get('tipo') == 1):
            $this->header();

            $this->diezmoOfrenda($year);
        elseif(Input::get('tipo') == 2):
            $this->header();

            $this->ofrendas($year);
        else:
            $this->header();

            $this->notOfrendas($year,Input::get('tipo'));
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
    public function notOfrendas($year,$tipo)
    {

        $pdf = Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Cell(10,7,utf8_decode('N°'),1,0,'C');
        $pdf .= Fpdf::Cell(80,7,utf8_decode('Miembros'),1,0,'C');
        $ofrendas = $this->typeIncomeRepository->getModel()->where('id',$tipo)->get();
        foreach($ofrendas AS $ofrenda):
            $ofrend = $this->incomeRepository->getModel()
                ->where('type_income_id',$ofrenda->id)->whereBetween('date',[($year-1).'-12-26',$year.'-12-25'])->sum('balance');
            if($ofrend > 0):
                $pdf .= Fpdf::Cell(20,7,substr(utf8_decode($ofrenda->name),0,6),1,0,'C');
            endif;
        endforeach;
        $pdf .= Fpdf::Cell(20,7,utf8_decode('Total'),1,0,'C');
        $miembros = $this->memberRepository->getModel()->orderBy('name','ASC')->get();
        $pdf .= Fpdf::Ln();
        $i=0;
        foreach($miembros AS $miembro):
            $i++;
            $pdf = Fpdf::SetFont('Arial','i',12);
            $pdf .= Fpdf::Cell(10,7,$i,1,0,'L');
            $pdf .= Fpdf::Cell(80,7,substr(utf8_decode($miembro->name.' '.$miembro->last),0,35),1,0,'L');
            $total = 0;
            foreach($ofrendas AS $ofrenda):
                $ofrend = $this->incomeRepository->getModel()->where('member_id',$miembro->id)
                    ->where('type_income_id',$ofrenda->id)->whereBetween('date',[($year-1).'-12-26',$year.'-12-25'])->sum('balance');
                $total += $ofrend;
                $sumOfrenda = $this->incomeRepository->getModel()
                    ->where('type_income_id',$ofrenda->id)->whereBetween('date',[($year-1).'-12-26',$year.'-12-25'])->sum('balance');
                if($sumOfrenda > 0):
                    if($ofrend > 0):
                        $pdf .= Fpdf::Cell(20,7,number_format($ofrend),1,0,'C');
                    else:
                        $pdf .= Fpdf::Cell(20,7,number_format(0),1,0,'C');
                    endif;
                endif;
            endforeach;
            $pdf .= Fpdf::Cell(20,7,number_format($total),1,0,'C');

            $pdf .= Fpdf::Ln();
        endforeach;
        $pdf = Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Cell(90,7,'Total:',1,0,'R');
        $ofrendas = $this->typeIncomeRepository->getModel()->where('id',$tipo)->get();
        $total=0;
        foreach($ofrendas AS $ofrenda):
            $ofrend = $this->incomeRepository->getModel()
                ->where('type_income_id',$ofrenda->id)->whereBetween('date',[($year-1).'-12-26',$year.'-12-25'])->sum('balance');
            if($ofrend > 0):
                $pdf .= Fpdf::Cell(20,7,number_format($ofrend,2),1,0,'C');
            endif;
            $total += $ofrend;
        endforeach;

        $pdf .= Fpdf::Cell(20,7,number_format($total),1,0,'C');

        $pdf .= Fpdf::Ln();
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
            $pdf = Fpdf::SetFont('Arial','i',8);
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
        $pdf = Fpdf::SetFont('Arial','B',6);
        $pdf .= Fpdf::Cell(60,7,'Total:',1,0,'R');
        $ofrendas = $this->typeIncomeRepository->getModel()->where('offering','si')->get();
        $total=0;
        foreach($ofrendas AS $ofrenda):
            $ofrend = $this->incomeRepository->getModel()
                ->where('type_income_id',$ofrenda->id)->whereBetween('date',[$year.'-01-01',$year.'-12-31'])->sum('balance');
            if($ofrend > 0):
                $pdf .= Fpdf::Cell(15,7,number_format($ofrend,2),1,0,'C');
            endif;
            $total += $ofrend;
        endforeach;

        $pdf .= Fpdf::Cell(20,7,number_format($total),1,0,'C');

        $pdf .= Fpdf::Ln();
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
        $pdf .= Fpdf::Cell(55,7,substr(utf8_decode('Total'),0,35),1,0,'L');
        for($i=0;$i<count($mes);$i++):
            $diezmo = $this->incomeRepository->getModel()->where('type_income_id',$typeDie[0])->whereBetween('date',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('balance');
            $totalDie += $diezmo;
            $pdf .= Fpdf::Cell(15,7,number_format($diezmo),1,0,'C');
            $ofrenda = $this->incomeRepository->getModel()->whereIn('type_income_id',$typeOfe)->whereBetween('date',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('balance');
            $totalOfe += $ofrenda;
            $pdf .= Fpdf::Cell(15,7,number_format($ofrenda),1,0,'C');
        endfor;
        $pdf .= Fpdf::Cell(15,7,number_format($totalDie),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,number_format($totalOfe),1,0,'C');
        $pdf .= Fpdf::Ln();
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

    /**
     * @param $year
     */
    public function departament($year)
    {
        $pdf  = Fpdf::AddPage('L','legal');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Apartado 10113-1000 San José, Costa Rica'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Teléfonos: 2224-8311 Fax:2225-0665'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Ingreso de Diezmos, Ofrendas y Otros de la Iglesia de Quepos'),0,1,'C');
        $periods = $this->periodRepository->oneWhere('year',$year);
        $i=79;
        foreach($periods AS $period):
            $i = $i +20;
        endforeach;
        $pdf .= Fpdf::Cell($i,7,utf8_decode('Año: '.$year),1,1,'C');

        $pdf = Fpdf::SetFont('Arial','B',10);
        $pdf .= Fpdf::Cell(5,7,utf8_decode('N°'),1,0,'C');
        $pdf .= Fpdf::Cell(40,7,utf8_decode('Departamento'),1,0,'C');
         foreach($periods AS $period):
            $pdf .= Fpdf::Cell(20,7,utf8_decode(substr(changeLetterMonth($period->month),0,3)),1,0,'C');
        endforeach;
        $pdf .= Fpdf::Cell(20,7,utf8_decode('Total'),1,0,'C');
        $pdf .= Fpdf::Cell(14,7,utf8_decode('%'),1,1,'C');



        $i=0;
        $departaments = $this->departamentRepository->getModel()->orderBy('name','ASC')->get();
        $departamen = $this->departamentRepository->getModel()->where('type','iglesia')->orderBy('name','ASC')->lists('id');
        $typesList = $this->typeIncomeRepository->getModel()->whereIn('departament_id',$departamen)->lists('id');
        $mes = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        foreach($departaments AS $key=>$departament): $i++;

            $total=0;
            $pdf = Fpdf::SetFont('Arial','B',8);
            $pdf .= Fpdf::Cell(5,7,$key+1,1,0,'L');
            $pdf .= Fpdf::Cell(40,7,substr(utf8_decode(ucwords(strtolower($departament->name))),0,33),1,0,'L');
            $types = $this->typeIncomeRepository->getModel()->where('departament_id',$departament->id)->lists('id');
            $totalDie=0;
            $pdf = Fpdf::SetFont('Arial','I',8);
            $periods = $this->periodRepository->oneWhere('year',$year);
            foreach($periods AS $period):
                $gasto = $this->incomeRepository->getModel()->whereIn('type_income_id',$types)
                    ->whereBetween('date',[$period->dateIn,$period->dateOut])->sum('balance');
                $totalDie += $gasto;

                $pdf .= Fpdf::Cell(20,7,number_format($gasto),1,0,'C');

            endforeach;
            $pdf = Fpdf::SetFont('Arial','BI',8);
            $pdf .= Fpdf::Cell(20,7,number_format($totalDie,2),1,0,'C');
            $total = $this->incomeRepository->getModel()->whereIn('type_income_id',$typesList)
                ->whereBetween('date',[($year-1).'-12-26',$year.'-12-25'])->sum('balance');
            $percent = ($totalDie/$total)*100;
            $pdf .= Fpdf::Cell(14,7,number_format($percent).'%',1,0,'C');
            $pdf .= Fpdf::Ln();
        endforeach;
        $pdf = Fpdf::SetFont('Arial','B',8);
        $pdf .= Fpdf::Cell(45,7,utf8_decode('Total'),1,0,'L');
        $pdf = Fpdf::SetFont('Arial','BI',7.5);
        $periods = $this->periodRepository->oneWhere('year',$year);
        foreach($periods AS $period):
            $gasto = $this->incomeRepository->getModel()
                ->whereBetween('date',[$period->dateIn,$period->dateOut])->sum('balance');
            $totalDie += $gasto;
            $pdf .= Fpdf::Cell(20,7,number_format($gasto),1,0,'C');

        endforeach;
        $pdf .= Fpdf::Cell(20,7,number_format($totalDie,2),1,0,'C');
        $percent = ($totalDie/$total)*100;
        $pdf .= Fpdf::Cell(14,7,number_format(100).'%',1,1,'C');
        $otherInc = OtherIncome::sum('amount');
        $pdf = Fpdf::SetFont('Arial','B',10);
        $periods = $this->periodRepository->oneWhere('year',$year);
        $i=45;
        foreach($periods AS $period):
            $i = $i +20;
        endforeach;
        $pdf .= Fpdf::Cell($i,7,'Total de Otros ingresos a la Cuentas Bancarias: ',1,0,'R');
        $pdf .= Fpdf::Cell(20,7,number_format($otherInc),1,1,'R');
        $pdf .= Fpdf::Cell($i,7,'Total Final depositado a las Cuentas Bancarias: ',1,0,'R');
        $pdf .= Fpdf::Cell(20,7,number_format($totalDie+$otherInc),1,1,'R');

        $pdf .= Fpdf::Output('Informe-de-Ingresos.pdf','I');
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