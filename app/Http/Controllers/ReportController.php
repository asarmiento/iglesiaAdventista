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
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\RecordRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;


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
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var MemberRepository
     */
    private $memberRepository;
    /**
     * @var TypeExpenseRepository
     */
    private $typeExpenseRepository;
    /**
     * @var ExpensesRepository
     */
    private $expensesRepository;
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;
    /**
     * @var RecordRepository
     */
    private $recordRepository;

    /**
     * ReportController constructor.
     * @param Fpdf $fpdf
     * @param TypeIncomeRepository $typeIncomeRepository
     * @param TypeExpenseRepository $typeExpenseRepository
     * @param IncomeRepository $incomeRepository
     * @param MemberRepository $memberRepository
     * @param ExpensesRepository $expensesRepository
     * @param DepartamentRepository $departamentRepository
     * @param RecordRepository $recordRepository
     * @internal param TypeIncomeRepository $TypeIncomeRepository
     * @internal param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     * @internal param TypeExpense $typeExpense
     */
    public function __construct(
        Fpdf $fpdf,
        TypeIncomeRepository $typeIncomeRepository,
        TypeExpenseRepository $typeExpenseRepository,
        IncomeRepository $incomeRepository,
        MemberRepository $memberRepository,
        ExpensesRepository $expensesRepository,
        DepartamentRepository $departamentRepository,
        RecordRepository $recordRepository
    )
    {

        $this->fpdf = $fpdf;
        $this->typeIncomeRepository = $typeIncomeRepository;

        $this->incomeRepository = $incomeRepository;
        $this->memberRepository = $memberRepository;
        $this->typeExpenseRepository = $typeExpenseRepository;
        $this->expensesRepository = $expensesRepository;
        $this->departamentRepository = $departamentRepository;
        $this->recordRepository = $recordRepository;
    }
    public function index()
    {
        return view('report.index');
    }


    public function store($date)
    {
        //$date = Input::get('date');

        $fixs = $this->TypeIncomeRepository->allData();

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

        $dateIni = '2016-01-01';
        $dateOut = '2016-01-31';
        $pdf  = Fpdf::AddPage('P','letter');
        $this->headerInforme();
        $this->ingresos($dateIni,$dateOut);
        $pdf  = Fpdf::AddPage('P','letter');
        $this->headerInforme();
        $this->association($dateIni,$dateOut);
        $pdf  = Fpdf::AddPage('P','letter');
        $this->headerInforme();
        $this->departament($dateIni,$dateOut);
        $pdf  = Fpdf::AddPage('P','letter');
        $this->headerInforme();
        $this->promedios($dateIni,$dateOut);
        $pdf  = Fpdf::AddPage('P','letter');
        $this->headerInforme();
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',16);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Tipos de Gastos'),0,1,'C');
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',14);

        $pdf  .= Fpdf::Cell(50,7,utf8_decode('Departamentos'),1,0,'C');
        $pdf  .= Fpdf::Cell(70,7,utf8_decode('Gasto'),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Mes'),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Acumulado'),1,1,'C');
        $typeExpenses = $this->typeExpenseRepository->allData();
        $totalmes=0;
        $totalAcum=0;
        foreach($typeExpenses AS $typeExpense):
            $pdf   = Fpdf::SetFont('Arial','',11);
            $pdf  .= Fpdf::Cell(50,5,utf8_decode(ucfirst(strtolower($typeExpense->departaments[0]->name))),1,0,'L');
            $pdf  .= Fpdf::Cell(70,5,utf8_decode(ucfirst(strtolower($typeExpense->name))),1,0,'L');
            $expense =$this->expensesRepository->getModel()
                ->join('type_expenses','type_expenses.id','=','expenses.type_expense_id')
                ->where('type_expense_id',$typeExpense->id)
                ->where('invoiceDate','>=',$dateIni)->where('invoiceDate','<=',$dateOut)->sum('expenses.amount');
            $totalmes +=$expense;
            $pdf  .= Fpdf::Cell(35,5,number_format($expense),1,0,'C');
            $expense =$this->expensesRepository->getModel()
                ->join('type_expenses','type_expenses.id','=','expenses.type_expense_id')
                ->where('type_expense_id',$typeExpense->id)->sum('expenses.amount');
            $pdf  .= Fpdf::Cell(35,5,number_format($expense),1,1,'C');
            $totalAcum +=$expense;
        endforeach;
        $pdf   .= Fpdf::SetX(55);
        $pdf  .= Fpdf::Cell(70,5,utf8_decode('Total: '),1,0,'L');
        $pdf  .= Fpdf::Cell(35,5,number_format($totalmes),1,0,'C');
        $pdf  .= Fpdf::Cell(35,5,number_format($totalAcum),1,1,'C');
        Fpdf::Output('Informe-Mensual-Ingresos-Gastos.pdf','I');
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
    public function promedios($dateIni,$dateOut)
    {
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',16);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Proyeción Departamentos de la Iglesia'),0,1,'C');
        $pdf   = Fpdf::Ln();
        $departaments = $this->departamentRepository->allData();
        $totalGtoA = 0;
        $totalProm = 0;
        $totalIngA=0;
        $partAsocAcum =0;
        $totalIngProm =0;
        $pdf   = Fpdf::SetFont('Arial','B',12);
        $pdf  .= Fpdf::SetX(20);
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Departamentos'),1,0,'L');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Presupuesto'),1,0,'L');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Prom. Ingresos'),1,0,'L');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Prom. Gastos'),1,0,'L');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Diferencia'),1,1,'L');
        foreach($departaments As $departament):
            $pdf   = Fpdf::SetFont('Arial','',9);
            $pdf   .= Fpdf::SetX(20);
            $pdf  .= Fpdf::Cell(35,7,utf8_decode($departament->name),1,0,'L');
            $pdf  .= Fpdf::Cell(35,7,number_format($departament->budget,2),1,0,'c');
            $totalProm +=$departament->budget;
            /*--------------------------------------------- Igresos Acumulado----------------------------------*/
            $income =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','NO')->sum('incomes.balance');
            $incomePart =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','SI')->sum('incomes.balance');
            $totalIngA += $income+$incomePart;
            $partAsocAcum +=($incomePart/5)*2;
            $partIgl =    ($incomePart/5)*3;
            $record = $this->recordRepository->getModel()->count();
            $year = ($record/4.3333333);

            if($departament->name == 'Fondos de Iglesia'):

                   if($departament->typeIncomes->out == 1):
                        $pdf  .= Fpdf::Cell(35,7,number_format(0,2),1,0,'C');
                    else:
                        $totalI = ($income+$partIgl)/$year;
                        $totalIngProm += $totalI;
                        $pdf  .= Fpdf::Cell(35,7,number_format($totalI,2),1,0,'C');
                    endif;

            elseif($departament->name == 'Asociacion Central'):

                $pdf  .= Fpdf::Cell(35,7,number_format(0,2),1,0,'C');
            else:

                if($departament->typeIncomes):
                    if($departament->typeIncomes->out == 1):
                        $pdf  .= Fpdf::Cell(35,7,number_format(0,2),1,0,'C');
                    else:
                        $totalI = ($income+$partIgl)/$year;
                        $totalIngProm += $totalI;
                        $pdf  .= Fpdf::Cell(35,7,number_format($totalI,2),1,0,'C');
                    endif;
                else:
                    $totalI = ($income+$partIgl)/$year;
                    $totalIngProm += $totalI;
                    $pdf  .= Fpdf::Cell(35,7,number_format($totalI,2),1,0,'C');

                endif;

            endif;
            $expense =$this->expensesRepository->getModel()
                ->join('type_expenses','type_expenses.id','=','expenses.type_expense_id')
                ->join('departaments','type_expenses.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->sum('expenses.amount');
            if($departament->name == 'Asociacion Central'):
                $sinAsoc = 0;
                $totalGtoA += 0;

            else:
                if($departament->typeExpenses):
                    if($departament->typeExpenses->out == 1):
                        $sinAsoc = 0;
                        $totalGtoA += 0;
                    else:
                        $sinAsoc = $expense;
                        $totalGtoA += $expense;
                    endif;
                else:
                    $sinAsoc = $expense;
                    $totalGtoA += $expense;
                endif;
            endif;
            $record = $this->recordRepository->getModel()->count();
            $year = ($record/4.3333333);
            $total = $sinAsoc/$year;
            $totalProm += $total;
            if($total < 0):
                $pdf  .= Fpdf::Cell(35,7,number_format($total*-1,2),1,0,'C');
            else:
                $pdf  .= Fpdf::Cell(35,7,number_format($total,2),1,0,'C');
            endif;
            if(($totalI-$total) < 0):
                $pdf  .= Fpdf::SetTextColor(249,50,0);
                $pdf  .= Fpdf::Cell(35,7,number_format($totalI-$total),1,1,'C');
                $pdf  .= Fpdf::SetTextColor(14,15,15);
            else:
                $pdf  .= Fpdf::SetTextColor(14,15,15);
                $pdf  .= Fpdf::Cell(35,7,number_format($totalI-$total),1,1,'C');
            endif;
        endforeach;
        $record = $this->recordRepository->getModel()->count();
        $year = ($record/4.3333333);
        $total = ($totalGtoA)/$year;
        $totaling = $totalIngProm/$year;

        $pdf  .= Fpdf::SetX(20);
        $pdf  .= Fpdf::Cell(35,7,'Total:' ,1,0,'R');
        $pdf  .= Fpdf::Cell(35,7,'',1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,number_format($totaling),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,number_format($total),1,0,'C');
        if(($totaling-$total) < 0):
            $pdf  .= Fpdf::SetTextColor(249,50,0);
            $pdf  .= Fpdf::Cell(35,7,number_format($totaling-$total),1,1,'C');
            $pdf  .= Fpdf::SetTextColor(14,15,15);
        else:
            $pdf  .= Fpdf::SetTextColor(14,15,15);
            $pdf  .= Fpdf::Cell(35,7,number_format($totaling-$total),1,1,'C');
        endif;
        return $pdf;
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
    public function departament($dateIni,$dateOut)
    {
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',16);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Departamentos de la Iglesia'),0,1,'C');
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',12);
        $pdf  .= Fpdf::SetX(10);
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Departamentos'),1,0,'L');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('presup.'),1,0,'C');
        $pdf  .= Fpdf::Cell(60,7,utf8_decode('Mes Actual'),1,0,'C');
        $pdf  .= Fpdf::Cell(70,7,utf8_decode('Acumulado'),1,1,'C');
        $pdf  .= Fpdf::SetX(65);
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Ing.'),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Gto'),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Dif.'),1,0,'C');
        $pdf  .= Fpdf::Cell(25,7,utf8_decode('Ing.'),1,0,'C');
        $pdf  .= Fpdf::Cell(25,7,utf8_decode('Gto'),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Dif.'),1,1,'C');

        $departaments = $this->departamentRepository->allData();
        $partAsoc = 0;
        $partAsocAcum = 0;

        /*---Totales finales----*/
        $totalPres =0;
        $totalIngM =0;
        $totalGtoM =0;
        $totalIngA =0;
        $totalGtoA =0;
        $totalProm =0;

        foreach($departaments As $departament):


            $pdf   = Fpdf::SetFont('Arial','',9);
            $totalIncome = $this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','NO')
                ->where('date','>=',$dateIni)
                ->where('date','<=',$dateOut)->sum('incomes.balance');
            $acum = $this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('part','NO')
                ->where('departament_id',$departament->id)->sum('incomes.balance');
            $totalAcum = $this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('part','NO')
                ->where('departament_id',$departament->id)->sum('incomes.balance');
            $pdf   .= Fpdf::SetX(10);
            $pdf  .= Fpdf::Cell(35,7,utf8_decode($departament->name),1,0,'L');
            $pdf  .= Fpdf::Cell(20,7,number_format($departament->budget,2),1,0,'c');
            $totalPres +=$departament->budget;
            /*--------------------------------------------- Igresos del mes----------------------------------*/
            $income =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','NO')
                ->where('date','>=',$dateIni)->where('date','<=',$dateOut)->sum('incomes.balance');
            $incomePart =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','SI')
                ->where('date','>=',$dateIni)->where('date','<=',$dateOut)->sum('incomes.balance');
            $totalIngM += $income+$incomePart;
            $partAsoc +=($incomePart/5)*2;
            $partIgl =    ($incomePart/5)*3;
            if($departament->name == 'Fondos de Iglesia'):
                $pdf  .= Fpdf::Cell(20,7,number_format($income+$partIgl,2),1,0,'C');
            elseif($departament->name == 'Asociacion Central'):
                $pdf  .= Fpdf::Cell(20,7,number_format($income+$partAsoc,2),1,0,'C');
            else:
                $pdf  .= Fpdf::Cell(20,7,number_format($income,2),1,0,'C');
            endif;
            /*--------------------------------------------- Gastos del mes----------------------------------*/
            $expense =$this->expensesRepository->getModel()
                ->join('type_expenses','type_expenses.id','=','expenses.type_expense_id')
                ->join('departaments','type_expenses.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)
                ->where('invoiceDate','>=',$dateIni)->where('invoiceDate','<=',$dateOut)->sum('expenses.amount');
            $pdf  .= Fpdf::Cell(20,7,number_format($expense,2),1,0,'C');
            $totalGtoM += $expense;
            /*--------------------------------------------- diferecnia del if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,0,'C');
                endif;mes----------------------------------*/
            if($departament->name == 'Fondos de Iglesia'):
                $difMonth=  ($income+$partIgl)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,0,'C');
                endif;
            elseif($departament->name == 'Asociacion Central'):
                $difMonth=  ($income+$partAsoc)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,0,'C');
                endif;
            else:
                $difMonth=  ($income)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,0,'C');
                endif;
            endif;
            $pdf   = Fpdf::SetFont('Arial','',8);
            /*--------------------------------------------- Igresos Acumulado----------------------------------*/
            $income =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','NO')->sum('incomes.balance');
            $incomePart =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','SI')->sum('incomes.balance');
            $totalIngA += $income+$incomePart;
            $partAsocAcum +=($incomePart/5)*2;
            $partIgl =    ($incomePart/5)*3;
            if($departament->name == 'Fondos de Iglesia'):
                $pdf  .= Fpdf::Cell(25,7,number_format($income+$partIgl,2),1,0,'C');
            elseif($departament->name == 'Asociacion Central'):
                $pdf  .= Fpdf::Cell(25,7,number_format($income+$partAsocAcum,2),1,0,'C');
            else:
                $pdf  .= Fpdf::Cell(25,7,number_format($income,2),1,0,'C');
            endif;
            /*--------------------------------------------- Gastos Acumulado----------------------------------*/
            $expense =$this->expensesRepository->getModel()
                ->join('type_expenses','type_expenses.id','=','expenses.type_expense_id')
                ->join('departaments','type_expenses.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->sum('expenses.amount');
            $pdf  .= Fpdf::Cell(25,7,number_format($expense,2),1,0,'C');

            if($departament->name == 'Fondos de Iglesia'):
                $difMonth=  ($income+$partIgl)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,1,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,1,'C');
                endif;
            else:
                $difMonth=  ($income)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,1,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,7,number_format($difMonth,2),1,1,'C');
                endif;
            endif;


        endforeach;
        $pdf  .= Fpdf::SetX(10);
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('TOTAL'),1,0,'R');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalPres),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalIngM),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalGtoM),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalIngM-$totalGtoM),1,0,'C');
        $pdf  .= Fpdf::Cell(25,7,number_format($totalIngA),1,0,'C');
        $pdf  .= Fpdf::Cell(25,7,number_format($totalGtoA),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalIngA-$totalGtoA),1,1,'C');



        return $pdf;
    }
    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-01-29
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
    public function association($dateIni,$dateOut)
    {
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',16);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Fondos de Asociación'),0,1,'C');
        $pdf   = Fpdf::Ln();
        $asociacion = $this->typeExpenseRepository->oneWhere('name','Fondos Asociación Diezmo, 20% 20%');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Fondos depositados a la '),0,1,'C');
        $pdf   = Fpdf::Ln();
        $asocAmountMonth= $this->expensesRepository->getModel()->where('type_expense_id',$asociacion[0]->id)
            ->where('invoiceDate','>=',$dateIni)->where('invoiceDate','<=',$dateOut)->sum('amount');
        $pdf   .= Fpdf::SetX(20);

        $pdf  .= Fpdf::Cell(80,5,utf8_decode('Monto Dep. Del Mes: '.number_format($asocAmountMonth,2)),0,0,'L');

        $asocAmountMonth= $this->expensesRepository->getModel()->where('type_expense_id',$asociacion[0]->id)
            ->sum('amount');
        $pdf  .= Fpdf::Cell(80,5,utf8_decode(' Acumulado: '.number_format($asocAmountMonth,2)),0,1,'R');

        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf   .= Fpdf::SetX(20);
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Tipo de Salida'),0,0,'L');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Mes Actual'),0,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Acumulado'),0,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('% Mes'),0,0,'C');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('% Acum.'),0,1,'C');
        $typeIncomes = $this->typeIncomeRepository->allData();
        foreach($typeIncomes As $typeIncome):
            if($typeIncome->association == 'SI'):
                $pdf   = Fpdf::SetFont('Arial','',12);
                $income =$this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)
                    ->where('date','>=',$dateIni)->where('date','<=',$dateOut)->sum('balance');

                $totalIncome = $this->incomeRepository->getModel()
                    ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                    ->where('association','SI')->where('date','>=',$dateIni)
                    ->where('date','<=',$dateOut)->sum('incomes.balance');
                $acum = $this->incomeRepository->oneWhereList('type_income_id',$typeIncome->id,'balance');
                $totalAcum = $this->incomeRepository->getModel()
                    ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                    ->where('association','SI')->sum('incomes.balance');
                $pdf   .= Fpdf::SetX(20);
                $pdf  .= Fpdf::Cell(40,7,utf8_decode($typeIncome->name),0,0,'L');
                if($typeIncome->name =='Ofrenda'):
                    $pdf  .= Fpdf::Cell(35,7,number_format(($income/5)*2,2),0,0,'C');
                    $pdf  .= Fpdf::Cell(40,7,number_format(($acum/5)*2,2),0,0,'C');
                elseif($typeIncome->name == 'Fondo Inv.'):
                    $pdf  .= Fpdf::Cell(35,7,number_format(($income/5)*2,2),0,0,'C');
                    $pdf  .= Fpdf::Cell(40,7,number_format(($acum/5)*2,2),0,0,'C');
                else:
                    $pdf  .= Fpdf::Cell(35,7,number_format($income,2),0,0,'C');
                    $pdf  .= Fpdf::Cell(40,7,number_format($acum,2),0,0,'C');
                endif;
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
            endif;
        endforeach;

        return $pdf;
    }
    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-01-28
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
                ->where('date','>=',$dateIni)->where('date','<=',$dateOut)->sum('balance');

            $totalIncome = $this->incomeRepository->getModel()->where('date','>=',$dateIni)
                ->where('date','<=',$dateOut)->sum('balance');
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
        $totalIncome = $this->incomeRepository->getModel()->where('date','>=',$dateIni)
            ->where('date','<=',$dateOut)->sum('balance');
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
   |@Date Create: 2015-01-28
   |@Date Update: 2015-00-00
   |---------------------------------------------------------------------
   |@Description: Generamos el encabezado del estado resultado
   |----------------------------------------------------------------------
   | @return mixed
   |----------------------------------------------------------------------
   */
    public function headerInforme()
    {

        $pdf  =Fpdf::PageNo();
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