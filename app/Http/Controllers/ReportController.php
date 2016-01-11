<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 08/01/16
 * Time: 05:16 PM
 */

namespace SistemasAmigables\Http\Controllers;


use Anouar\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Entities\TypeExpense;
use SistemasAmigables\Entities\TypeFixedIncome;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\TypeFixedRepository;
use SistemasAmigables\Repositories\TypeTemporaryIncomeRepository;

class ReportController extends  Controller
{
    /**
     * @var Fpdf
     */
    private $fpdf;
    /**
     * @var TypeFixedRepository
     */
    private $typeFixedRepository;
    /**
     * @var TypeTemporaryIncomeRepository
     */
    private $typeTemporaryIncomeRepository;
    /**
     * @var TypeExpense
     */
    private $typeExpense;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var MemberRepository
     */
    private $memberRepository;

    /**
     * ReportController constructor.
     * @param Fpdf $fpdf
     * @param TypeFixedRepository $typeFixedRepository
     * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     * @param TypeExpense $typeExpense
     * @param IncomeRepository $incomeRepository
     * @param MemberRepository $memberRepository
     */
    public function __construct(
        Fpdf $fpdf,
        TypeFixedRepository $typeFixedRepository,
        TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository,
        TypeExpense $typeExpense,
        IncomeRepository $incomeRepository,
        MemberRepository $memberRepository

    )
    {

        $this->fpdf = $fpdf;
        $this->typeFixedRepository = $typeFixedRepository;
        $this->typeTemporaryIncomeRepository = $typeTemporaryIncomeRepository;
        $this->typeExpense = $typeExpense;
        $this->incomeRepository = $incomeRepository;
        $this->memberRepository = $memberRepository;
    }
    public function index()
    {
        return view('report.index');
    }


    public function store($date)
    {
        $date = Input::get('date');

        $fixs = $this->typeFixedRepository->allData();
        $temporals = $this->typeTemporaryIncomeRepository->allData();
        $miembros = $this->memberRepository->allData();
        $this->header($miembros);

        $pdf    = Fpdf::SetFont('Arial','B',7);
        $pdf    = Fpdf::SetX(5);
        $pdf  .= Fpdf::Cell(5,7,utf8_decode('N°'),1,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Nombres'),1,0,'C');
        $pdf  .= Fpdf::Cell(13,7,utf8_decode('Recibo N°'),1,0,'C');
        $i=0;
        foreach($fixs AS $fix): $i++;
        $pdf  .= Fpdf::Cell(12,7,substr(utf8_decode($fix->name),0,8),1,0,'C');
        endforeach;
        foreach($temporals AS $temporal): $i++;
            $pdf  .= Fpdf::Cell(12,7,substr(utf8_decode($temporal->name),0,8),1,0,'C');
        endforeach;
        $pdf  .= Fpdf::ln();
        $e =0;
        /* INICIO DE CUERPO */
        foreach($miembros AS $miembro):
            if($miembro->incomes): $e++;
            $pdf    .= Fpdf::SetX(5);
            $pdf  .= Fpdf::Cell(5,7,utf8_decode($e),1,0,'C');
            $pdf  .= Fpdf::Cell(40,7,substr(utf8_decode($miembro->completo()),0,30),1,0,'L');
            $pdf  .= Fpdf::Cell(13,7,$miembro->incomes->numberOf,1,0,'C');
            foreach($fixs AS $fix):
                $pdf  .= Fpdf::Cell(12,7,number_format($miembro->incomes->treeWhere('typeFixedIncome_id',$fix->id,'member_id',$miembro->id,'date',$date)),1,0,'C');
            endforeach;
            foreach($temporals AS $temporal):
                $pdf  .= Fpdf::Cell(12,7,number_format($miembro->incomes->treeWhere('typesTemporaryIncome_id',$temporal->id,'member_id',$miembro->id,'date',$date)),1,0,'C');
            endforeach;
            $pdf  .= Fpdf::ln();
            endif;
        endforeach;
        /*fIN DE CUERPO*/
        $pdf    = Fpdf::SetX(5);
        $pdf  .= Fpdf::Cell(58,7,'TOTALES _  _  _  _  _  _',0,0,'R');
        foreach($fixs AS $fix):
            $pdf  .= Fpdf::Cell(12,7,number_format($miembro->incomes->twoWhere('typeFixedIncome_id',$fix->id,'date',$date)),1,0,'C');
        endforeach;
        foreach($temporals AS $temporal):
            $pdf  .= Fpdf::Cell(12,7,number_format($miembro->incomes->twoWhere('typesTemporaryIncome_id',$temporal->id,'date',$date)),1,0,'C');
        endforeach;


        $pdf  .= Fpdf::ln();
        $pdf  .= Fpdf::ln();
        $y = Fpdf::GetY();
        $pdf .= $this->firmas();
        $pdf = Fpdf::SetXY(110,$y);
        $pdf .= $this->footer($date);
        Fpdf::Output();
        exit;
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2015-11-08
    |@Date Update: 2015-00-00
    |---------------------------------------------------------------------
    |@Description: Generamos el encabezado del estado resultado
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    public function header($data)
    {
        $pdf  = Fpdf::AddPage();
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Apartado 10113-1000 San José, Costa Rica'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Teléfonos: 2224-8311 Fax:2225-0665'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Control Semanal de Diezmos y Ofrendas'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','',12);
        $pdf .= Fpdf::Setx(5);
        $pdf .= Fpdf::Cell(0,7,'Iglesia:  Quepos                                                            Fecha:  '.$data[0]->incomes->date,0,1,'L');
            return $pdf;
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2015-01-10
    |@Date Update: 2015-00-00
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
    public function firmas()
    {
        $y = Fpdf::GetY();
        $pdf = Fpdf::SetXY(110,$y);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('______________________________'),0,1,'L');
        $pdf = Fpdf::SetX(110);
        $pdf  .= Fpdf::Cell(40,5,utf8_decode('Tesorero'),0,1,'C');
        $pdf = Fpdf::SetX(110);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('______________________________'),0,1,'L');
        $pdf = Fpdf::SetX(110);
        $pdf  .= Fpdf::Cell(40,5,utf8_decode('Pastor o Anciano'),0,1,'C');
        $pdf = Fpdf::SetX(110);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('______________________________'),0,1,'L');
        $pdf = Fpdf::SetX(110);
        $pdf  .= Fpdf::Cell(40,5,utf8_decode('Dir. Mayordomia o Diacono'),0,1,'C');
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2015-01-10
    |@Date Update: 2015-00-00
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
    public function footer($date)
    {
        $pdf  = Fpdf::SetX(10);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('DIEZMOS'),0,0,'L');
        $diezmo = $this->typeFixedRepository->name('name','Diezmos');
        $diezmoTotal = $this->incomeRepository->getModel()->twoWhere('date',$date,'typeFixedIncome_id',$diezmo[0]->id);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($diezmoTotal),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('20% MUNDIAL'),0,0,'L');
        $ofrenda = $this->typeFixedRepository->name('name','Ofrenda');
        $ofrendaTotal = $this->incomeRepository->getModel()->twoWhere('date',$date,'typeFixedIncome_id',$ofrenda[0]->id);
        $fondo = $this->typeFixedRepository->name('name','Fondo Inv.');
        $fondoTotal =$this->incomeRepository->getModel()->twoWhere('date',$date,'typeFixedIncome_id',$fondo[0]->id);
        $asoc = ($ofrendaTotal+$fondoTotal)/5;
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($asoc),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('20% DESARROLLO'),0,0,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($asoc),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('RECOLECCION'),0,0,'L');
        $diezmo = $this->typeFixedRepository->name('name','Recoleccion');
        $recoleccion = $this->incomeRepository->getModel()->twoWhere('date',$date,'typeFixedIncome_id',$diezmo[0]->id);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($recoleccion),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('RADIO'),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('REVISTA'),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('OTROS'),0,1,'L');
        $pdf  .= Fpdf::Cell(40,5,utf8_decode('TOTAL ASOCIACION'),0,0,'L');
        $total = $diezmoTotal+$asoc+$recoleccion;
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($total),0,1,'L');

        $pdf  .= Fpdf::ln();
        $pdf  .= Fpdf::Cell(60,5,utf8_decode('FONDOS LOCALES 60% PRESUPUESTO'),0,0,'L');
        $fondo = $asoc*3;
        $temporals = $this->typeTemporaryIncomeRepository->allData();

        foreach($temporals AS $temporal):
            $fondo  += $this->incomeRepository->getModel()->twoWhere('typesTemporaryIncome_id',$temporal->id,'date',$date);
        endforeach;

        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($fondo),0,1,'L');
        return $pdf;
    }
}