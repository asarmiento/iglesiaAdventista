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
use SistemasAmigables\Repositories\TypeIncomeRepository;
use SistemasAmigables\Repositories\TypeTemporaryIncomeRepository;

class ReportController extends  Controller
{
    /**
     * @var Fpdf
     */
    private $fpdf;
    /**
     * @var TypeIncomeRepository
     */
    private $typeIncomeRepository;
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
     * @param TypeIncomeRepository $TypeIncomeRepository
     * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     * @param TypeExpense $typeExpense
     * @param IncomeRepository $incomeRepository
     * @param MemberRepository $memberRepository
     */
    public function __construct(
        Fpdf $fpdf,
        TypeIncomeRepository $typeIncomeRepository,

        TypeExpense $typeExpense,
        IncomeRepository $incomeRepository,
        MemberRepository $memberRepository

    )
    {

        $this->fpdf = $fpdf;
        $this->typeIncomeRepository = $typeIncomeRepository;

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
        //$date = Input::get('date');

        $fixs = $this->TypeIncomeRepository->allData();
      //  $temporals = $this->typeTemporaryIncomeRepository->allData();
        $miembros = $this->memberRepository->allData();
        $income = $this->incomeRepository->getModel();
        $this->header($date);

        $pdf    = Fpdf::SetFont('Arial','B',7);
        $pdf    = Fpdf::SetX(5);
        $pdf  .= Fpdf::Cell(5,7,utf8_decode('N°'),1,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Nombres'),1,0,'C');
        $pdf  .= Fpdf::Cell(13,7,utf8_decode('Recibo N°'),1,0,'C');
        $i=0;
        foreach($fixs AS $fix): $i++;
            $amount=  $this->incomeRepository->twoWhereList('type_income_id',$fix->id,'date',$date,'balance');

            if($amount > 0):
                $pdf  .= Fpdf::Cell(13,7,substr(utf8_decode($fix->name),0,8),1,0,'C');
            endif;
        endforeach;

        $pdf  .= Fpdf::ln();
        $e =0;
        /* INICIO DE CUERPO */
        foreach($miembros AS $miembro):
            if(!$income->where('member_id',$miembro->id)->where('date',$date)->get()->isEmpty()): $e++;
            $pdf    .= Fpdf::SetX(5);
            $pdf  .= Fpdf::Cell(5,7,utf8_decode($e),1,0,'C');
            $pdf  .= Fpdf::Cell(40,7,substr(utf8_decode($miembro->completo()),0,30),1,0,'L');
            $pdf  .= Fpdf::Cell(13,7,$miembro->incomes->numberOf,1,0,'C');
            foreach($fixs AS $fix):
                $amount=  $this->incomeRepository->twoWhereList('type_income_id',$fix->id,'date',$date,'balance');
                if($amount > 0):
                    $pdf  .= Fpdf::Cell(13,7,number_format($miembro->incomes->treeWhere('type_income_id',$fix->id,'member_id',$miembro->id,'date',$date),2),1,0,'C');
                endif;
                endforeach;

            $pdf  .= Fpdf::ln();
            endif;
        endforeach;
        /*fIN DE CUERPO*/
        $pdf    = Fpdf::SetX(5);
        $pdf  .= Fpdf::Cell(58,7,'TOTALES _  _  _  _  _  _',0,0,'R');
        foreach($fixs AS $fix):
            $amount=  $this->incomeRepository->twoWhereList('type_income_id',$fix->id,'date',$date,'balance');
            if($amount > 0):
                $pdf  .= Fpdf::Cell(13,7,number_format($income->twoWhere('type_income_id',$fix->id,'date',$date),2),1,0,'C');
            endif;
        endforeach;



        $pdf  .= Fpdf::ln();
        $pdf  .= Fpdf::ln();
        $y = Fpdf::GetY();
        $pdf .= $this->firmas();
        $pdf = Fpdf::SetXY(110,$y);
        $pdf .= $this->footer($date);
        Fpdf::Output('Informe-Semana: '.$date.'.pdf','I');
        exit;
    }
    private function Search($campo,$data,$campo1,$data1)
    {
        return $this->incomeRepository->getModel()
            ->where($campo,$data)->where($campo1,$data1)->sum('balance');
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
        $pdf  = Fpdf::AddPage('P','letter');
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
        $pdf .= Fpdf::Cell(0,7,'Iglesia:  Quepos                                                            Fecha:  '.$data,0,1,'L');
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
        $diezmo = $this->TypeIncomeRepository->name('name','Diezmos');
        $diezmoTotal = $this->incomeRepository->getModel()->twoWhere('date',$date,'type_income_id',$diezmo[0]->id);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($diezmoTotal,2),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('20% MUNDIAL'),0,0,'L');
        $ofrenda = $this->TypeIncomeRepository->name('name','Ofrenda');
        $ofrendaTotal = $this->incomeRepository->getModel()->twoWhere('date',$date,'type_income_id',$ofrenda[0]->id);
        $fondo = $this->TypeIncomeRepository->name('name','Fondo Inv.');
        $fondoTotal =$this->incomeRepository->getModel()->twoWhere('date',$date,'type_income_id',$fondo[0]->id);
        $asoc = ($ofrendaTotal+$fondoTotal)/5;
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($asoc,2),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('20% DESARROLLO'),0,0,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($asoc,2),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('RECOLECCION'),0,0,'L');
        $diezmo = $this->TypeIncomeRepository->name('name','Recoleccion');
        if(!$diezmo->isEmpty()):
            $recoleccion = $this->incomeRepository->getModel()->twoWhere('date',$date,'type_income_id',$diezmo[0]->id);
        else:
            $recoleccion =0;
        endif;
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($recoleccion,2),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('RADIO'),0,0,'L');
        $radio = $this->TypeIncomeRepository->name('name','Radio y T.V.');
        if(!$radio->isEmpty()):
        $radioTotal = $this->incomeRepository->getModel()->twoWhere('date',$date,'type_income_id',$radio[0]->id);
        else:
            $radioTotal =0;
        endif;
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($radioTotal,2),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('REVISTA'),0,0,'L');
        $revista = $this->TypeIncomeRepository->name('name','Prioridades');
            if(!$revista->isEmpty()):
        $revistaTotal = $this->incomeRepository->getModel()->twoWhere('date',$date,'type_income_id',$revista[0]->id);
            else:
                $revistaTotal =0;
            endif;
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($revistaTotal,2),0,1,'L');
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('OTROS'),0,1,'L');
        $pdf  .= Fpdf::Cell(40,5,utf8_decode('TOTAL ASOCIACION'),0,0,'L');
        $total = $diezmoTotal+$asoc+$recoleccion+$revistaTotal+$radioTotal;
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($total,2),0,1,'L');

        $pdf  .= Fpdf::ln();
        $pdf  .= Fpdf::Cell(60,5,utf8_decode('FONDOS LOCALES 60% PRESUPUESTO'),0,0,'L');
        $fondo = $asoc*3;

        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($fondo,2),0,1,'L');
        return $pdf;
    }


    /**************************************Reporte de informe semanal*******************************************/


    public function informe()
    {
       $this->headerInforme();
        $dateIni = '2016-01-01';
        $dateOut = '2016-01-31';
        $this->ingresos($dateIni,$dateOut);
        Fpdf::Output('Informe-Mensual-Ingresos-Gastos.pdf','I');
        exit;
    }

    public function ingresos($dateIni,$dateOut)
    {
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',16);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Ingresos'),0,1,'C');

        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf   .= Fpdf::SetX(20);
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Tipo de Ingreso'),0,0,'L');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Mes Actual'),0,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Acumulado'),0,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('% Mes'),0,0,'C');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('% Acum.'),0,1,'C');
        $typeIncomes = $this->typeIncomeRepository->allData();
        foreach($typeIncomes As $typeIncome):
            $pdf   = Fpdf::SetFont('Arial','',12);
            $income =$this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)
                ->where('type_income_id','>=',$dateIni)->where('type_income_id','<=',$dateOut)->sum('balance');
            $totalIncome = $this->incomeRepository->getModel()->where('type_income_id','>=',$dateIni)
                ->where('type_income_id','<=',$dateOut)->sum('balance');
            $acum = $this->incomeRepository->oneWhereList('type_income_id',$typeIncome->id,'balance');
            $totalAcum = $this->incomeRepository->allSum('balance');
            $pdf   .= Fpdf::SetX(20);
            $pdf  .= Fpdf::Cell(40,7,utf8_decode($typeIncome->name),0,0,'L');
            $pdf  .= Fpdf::Cell(35,7,number_format($income,2),0,0,'C');
            $pdf  .= Fpdf::Cell(40,7,number_format($acum,2),0,0,'C');
            if($income>0):
                $pdf  .= Fpdf::Cell(40,7,number_format(($income/$totalIncome)*100,2).'%',0,0,'C');
            else:
                $pdf  .= Fpdf::Cell(40,7,number_format(0,2).'%',0,0,'C');
            endif;
            if($acum>0):
                $pdf  .= Fpdf::Cell(35,7,number_format(($acum/$totalAcum)*100,2).'%',0,1,'C');
            else:
                $pdf  .= Fpdf::Cell(35,7,number_format(0,2).'%',0,1,'C');
            endif;

        endforeach;
        $totalIncome = $this->incomeRepository->getModel()->where('type_income_id','>=',$dateIni)
            ->where('type_income_id','<=',$dateOut)->sum('balance');
        $totalAcum = $this->incomeRepository->allSum('balance');
        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf   .= Fpdf::SetX(20);
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Total'),0,0,'L');
        $pdf  .= Fpdf::Cell(35,7,number_format($totalIncome),0,0,'C');
        $pdf  .= Fpdf::Cell(40,7,number_format($totalAcum),0,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('100%'),0,0,'C');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('100%'),0,1,'C');

        return $pdf;
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
    public function headerInforme()
    {
        $pdf  = Fpdf::AddPage('P','letter');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Apartado 10113-1000 San José, Costa Rica'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Teléfonos: 2224-8311 Fax:2225-0665'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Iglesia de Quepos'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Informe Mensual de Ingresos y Gastos'),0,1,'C');
        return $pdf;
    }
}