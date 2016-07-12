<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 08/01/16
 * Time: 05:16 PM
 */

namespace SistemasAmigables\Http\Controllers;


use Anouar\Fpdf\Facades\Fpdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Entities\Campo;
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

        $fixs = $this->typeIncomeRepository->allData();

        $miembros = $this->memberRepository->allData();
        $incomes = $this->incomeRepository->getModel()->where('date',$date)->groupBy('numberOf')->orderBy('id','ASC')->get();
        $i=0;
        foreach($fixs AS $fix):
            $amount=  $this->incomeRepository->twoWhereList('type_income_id',$fix->id,'date',$date,'balance');

            if($amount > 0):
                $i++;
            endif;
        endforeach;
        if($i <= 9):
            $orientacion = 'P';
            else:
                $orientacion = 'L';
                endif;
        $this->header($date,$orientacion);

        $pdf    = Fpdf::SetFont('Arial','B',7);
        $pdf    = Fpdf::SetX(5);
        $pdf  .= Fpdf::Cell(5,7,utf8_decode('N°'),1,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Nombres'),1,0,'C');
        $pdf  .= Fpdf::Cell(13,7,utf8_decode('Recibo N°'),1,0,'C');
        $pdf  .= Fpdf::Cell(13,7,utf8_decode('Total'),1,0,'C');
        $i=0;
        foreach($fixs AS $fix): $i++;
            $amount=  $this->incomeRepository->twoWhereList('type_income_id',$fix->id,'date',$date,'balance');

            if($amount > 0):
                $pdf  .= Fpdf::Cell(13,7,substr(utf8_decode($fix->name),0,8),1,0,'C');
            endif;
        endforeach;

        $pdf  .= Fpdf::ln();
        $e =0;
        $fin = 0;
        /* INICIO DE CUERPO */
        foreach($incomes AS $income):
            $miembros = $this->memberRepository->getModel()->where('type','miembro')->where('id',$income->member_id)->get();
            if(!$miembros->isEmpty()):
            $e++;
            $pdf    .= Fpdf::SetX(5);
            $pdf  .= Fpdf::Cell(5,7,utf8_decode($e),1,0,'C');
            $pdf  .= Fpdf::Cell(40,7,substr(utf8_decode($miembros[0]->completo()),0,30),1,0,'L');
            $pdf  .= Fpdf::Cell(13,7,$miembros[0]->incomes->numberOf,1,0,'C');
                $total = $this->incomeRepository->getModel()->where('date',$date)->where('numberOf',$income->numberOf)->where('member_id',$miembros[0]->id)->sum('balance');
                $fin += $total;
                $pdf  .= Fpdf::Cell(13,7,number_format($total,2),1,0,'C');
            foreach($fixs AS $fix):
                $amount=  $this->incomeRepository->twoWhereList('type_income_id',$fix->id,'date',$date,'balance');
                if($amount > 0):
                    $pdf  .= Fpdf::Cell(13,7,number_format($miembros[0]->incomes->fourWhere('type_income_id',$fix->id,'member_id',$miembros[0]->id,'date',$date,'numberOf',$income->numberOf),2),1,0,'C');
                endif;
            endforeach;

            $pdf  .= Fpdf::ln();
        endif;

        endforeach;
        /*fIN DE CUERPO*/
        $pdf    = Fpdf::SetFont('Arial','B',6.5);
        $pdf    = Fpdf::SetX(5);
        $pdf  .= Fpdf::Cell(58,7,'TOTALES _  _  _  _  _  _',0,0,'R');
        $pdf  .= Fpdf::Cell(13,7,number_format($fin,2),1,0,'R');
        foreach($fixs AS $fix):
            $amount=  $this->incomeRepository->twoWhereList('type_income_id',$fix->id,'date',$date,'balance');
            if($amount > 0):
                $pdf  .= Fpdf::Cell(13,7,number_format($income->twoWhere('type_income_id',$fix->id,'date',$date),2),1,0,'C');
            endif;
        endforeach;



        $pdf  .= Fpdf::ln();
        $pdf  .= Fpdf::ln();
        $y = Fpdf::GetY();
        $pdf .= $this->firmas($orientacion);
        $pdf = Fpdf::SetXY(110,$y);
        $pdf .= $this->footer($date,$orientacion,$y);
        Fpdf::Output('Informe-Semanal: '.$date.'.pdf','I');
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
    public function header($data,$orientacion)
    {
        $pdf  = Fpdf::AddPage($orientacion,'letter');
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
    public function firmas($orientacion)
    {
        $y = Fpdf::GetY();
        if($orientacion == 'L' && $y > 150):
            $y = $y+170;
        endif;
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

 /**************************************************
 * @Author: Anwar Sarmiento Ramos
 * @Email: asarmiento@sistemasamigables.com
 * @Create: 10/01/16 07:10 PM   @Update 2016-07-11
 ***************************************************
 * @Description: En esta accion creamos el bloque
 *  de los totales de la asociacion y la iglesia
 *
 *
 * @Pasos:
 *
 *
 * @return
 ***************************************************/
    public function footer($date,$orientacion,$y)
    {

        $pdf = Fpdf::SetFont('Arial','',8);
        if($orientacion == 'L' && $y > 150):
            $y = $y-160;
            $pdf  = Fpdf::SetY($y);
        endif;
        $typeIncomes = $this->typeIncomeRepository->name('association','si');
        $i = 0;
        foreach($typeIncomes AS $typeIncome):
            $pdf  .= Fpdf::SetX(10);
            if($typeIncome->part == 'si'): $i++;
                $type = $this->typeIncomeRepository->getModel()->where('part','si')->lists('id');
                $ofrenda = $this->incomeRepository->getModel()->where('date',$date)->whereIn('type_income_id',$type)->sum('balance');
                if($i==1):
                $pdf  .= Fpdf::Cell(30,5,utf8_decode('20% MUNDIAL'),0,0,'L');
                $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format(($ofrenda/5),2),0,1,'L');
                else:
                    $pdf  .= Fpdf::Cell(30,5,utf8_decode('20% DESARROLLO'),0,0,'L');
                    $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format(($ofrenda/5),2),0,1,'L');
                endif;
             else:
                 $pdf  .= Fpdf::Cell(30,5,utf8_decode(strtoupper($typeIncome->name)),0,0,'L');
                 $Total = $this->incomeRepository->getModel()->twoWhere('date',$date,'type_income_id',$typeIncome->id);
                 $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($Total,2),0,1,'L');
             endif;
        endforeach;

        $record = $this->recordRepository->getModel()->where('saturday',$date)->get();

        $association = $this->incomeRepository->amountCampo($record[0]->id);
        $pdf  .= Fpdf::Cell(45,5,utf8_decode('TOTAL ASOCIACION'),0,0,'L');

        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($association,2),0,1,'L');

        $pdf  .= Fpdf::ln();
        $pdf  .= Fpdf::Cell(60,5,utf8_decode('FONDOS LOCALES 60% PRESUPUESTO'),0,0,'L');

        $fondo = $record[0]->balance-$association;

        $pdf  .= Fpdf::Cell(30,5,utf8_decode('¢ ').number_format($fondo,2),0,1,'L');
        return $pdf;
    }


    /**************************************Reporte de informe semanal*******************************************/


    public function informe()
    {

        $dateIni = Input::get('dateIn');
        $dateOut = Input::get('dateOut');
       $pdf  = Fpdf::AddPage('P','letter');
        $this->headerInforme();
       $pdf  .= Fpdf::Cell(0,5,utf8_decode($dateIni.' al '.$dateOut),0,1,'C');

       $this->ingresos($dateIni,$dateOut);
       $pdf  = Fpdf::AddPage('P','letter');
        $this->headerInforme();
        $this->association($dateIni,$dateOut);
      /*  $pdf  = Fpdf::AddPage('L','letter');
        $this->headerInforme();
        $this->departament($dateIni,$dateOut);
       /* $pdf  = Fpdf::AddPage('P','letter');
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
        $pdf   .= Fpdf::SetX(60);
        $pdf  .= Fpdf::Cell(70,5,utf8_decode('Total: '),1,0,'L');
        $pdf  .= Fpdf::Cell(35,5,number_format($totalmes),1,0,'C');
        $pdf  .= Fpdf::Cell(35,5,number_format($totalAcum),1,1,'C');*/
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
                ->where('departament_id',$departament->id)->where('part','NO')->whereBetween('date',['2016-01-01','2016-02-28'])->sum('incomes.balance');
            $incomePart =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','si')->whereBetween('date',['2016-01-01','2016-02-28'])->sum('incomes.balance');
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
                ->where('departament_id',$departament->id)->whereBetween('date',['2016-01-01','2016-02-28'])->sum('expenses.amount');
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
      /*  $record = $this->recordRepository->getModel()->count();
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
        endif;*/
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
        $pdf  .= Fpdf::Cell(5,7,utf8_decode('N°'),1,0,'L');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Departamentos'),1,0,'L');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('presup.'),1,0,'C');
        $date = new Carbon($dateIni);
        $pdf  .= Fpdf::Cell(60,7,utf8_decode('Mes '.$date->subMonth(1)->format('M')),1,0,'C');
        $date = new Carbon($dateIni);
        $pdf  .= Fpdf::Cell(60,7,utf8_decode('Mes '.$date->format('M')),1,0,'C');
        $pdf  .= Fpdf::Cell(70,7,utf8_decode('Año '.$date->format('Y')),1,1,'C');
        $pdf  .= Fpdf::SetX(70);
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Ing.'),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Gto'),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Dif.'),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Ing.'),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Gto'),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Dif.'),1,0,'C');
        $pdf  .= Fpdf::Cell(25,7,utf8_decode('Ing.'),1,0,'C');
        $pdf  .= Fpdf::Cell(25,7,utf8_decode('Gto'),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('Dif.'),1,1,'C');

        $partAsoc = 0;
        $partAsocAcum = 0;

        /*---Totales finales----*/
        $totalPres =0;
        $totalIngM =0;
        $totalGtoM =0;
        $totalIngA =0;
        $totalGtoA =0;
        $totalProm =0;
        $totalIngMAnt = 0;
        $partAsocAnt =0;
        $totalGtoMAnt=0;
        $departaments = $this->departamentRepository->allData();
    $i=0;
        foreach($departaments As $departament):
$i++;

            $pdf   = Fpdf::SetFont('Arial','',9);
            $totalIncome = $this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','no')
                ->where('date','>=',$dateIni)
                ->where('date','<=',$dateOut)->sum('incomes.balance');
            $acum = $this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('part','no')
                ->where('departament_id',$departament->id)->sum('incomes.balance');
            $totalAcum = $this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('part','no')
                ->where('departament_id',$departament->id)->sum('incomes.balance');
            $pdf   .= Fpdf::SetX(10);
            $pdf  .= Fpdf::Cell(5,6,utf8_decode($i),1,0,'L');
            $pdf  .= Fpdf::Cell(35,6,utf8_decode($departament->name),1,0,'L');
            $pdf  .= Fpdf::Cell(20,6,number_format($departament->budget,2),1,0,'c');
            $totalPres +=$departament->budget;
            /*--------------------------------------------- Igresos del mes Anterior----------------------------------*/
            $date = new Carbon($dateIni);
            $income =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','no')
                ->whereBetween('date',[$date->subMonth(1)->format('Y-m-d'),$date->endOfMonth()->format('Y-m-d')])->sum('incomes.balance');
            $date = new Carbon($dateIni);

            $incomePart =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','si')
                ->whereBetween('date',[$date->subMonth(1)->format('Y-m-d'),$date->endOfMonth()->format('Y-m-d')])->sum('incomes.balance');
            $totalIngMAnt += $income+$incomePart;
            $partAsocAnt +=($incomePart/5)*2;
            $partIgl =    ($incomePart/5)*3;
            if($departament->name == 'Fondos de Iglesia'):
                $pdf  .= Fpdf::Cell(20,6,number_format($income+$partIgl,2),1,0,'C');
            elseif($departament->name == 'Asociacion Central'):
                $pdf  .= Fpdf::Cell(20,6,number_format($income+$partAsoc,2),1,0,'C');
            else:
                $pdf  .= Fpdf::Cell(20,6,number_format($income,2),1,0,'C');
            endif;
            /*--------------------------------------------- Gastos del mes Anterior----------------------------------*/
            $date = new Carbon($dateIni);
            $expense = $this->expensesRepository->getModel()
                ->join('type_expenses','type_expenses.id','=','expenses.type_expense_id')->where('departament_id',$departament->id)
                ->whereBetween('invoiceDate',[$date->subMonth(1)->format('Y-m-d'),$date->endOfMonth()->format('Y-m-d')])->sum('amount');
            $pdf  .= Fpdf::Cell(20,6,number_format($expense,2),1,0,'C');
            $totalGtoMAnt += $expense;

            if($departament->name == 'Fondos de Iglesia'):
                $difMonth=  ($income+$partIgl)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                endif;

            elseif($departament->name == 'Asociacion Central'):
                $difMonth=  ($income+$partAsoc)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                endif;
            else:
                $difMonth=  ($income)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                endif;
            endif;
            /*--------------------------------------------- Igresos del mes Actual----------------------------------*/
            $income =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','no')
                ->whereBetween('date',[$dateIni,$dateOut])->sum('incomes.balance');
            $incomePart =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->join('departaments','type_incomes.departament_id','=','departaments.id')
                ->where('departament_id',$departament->id)->where('part','si')
                ->whereBetween('date',[$dateIni,$dateOut])->sum('incomes.balance');
            $totalIngM += $income+$incomePart;
            $partAsoc +=($incomePart/5)*2;
            $partIgl =    ($incomePart/5)*3;
            if($departament->name == 'Fondos de Iglesia'):
                $pdf  .= Fpdf::Cell(20,6,number_format($income+$partIgl,2),1,0,'C');
            elseif($departament->name == 'Asociacion Central'):
                $pdf  .= Fpdf::Cell(20,6,number_format($income+$partAsoc,2),1,0,'C');
            else:
                $pdf  .= Fpdf::Cell(20,6,number_format($income,2),1,0,'C');
            endif;
            /*--------------------------------------------- Gastos del mes Actual----------------------------------*/
            $expense = $this->expensesRepository->getModel()
                ->join('type_expenses','type_expenses.id','=','expenses.type_expense_id')->where('departament_id',$departament->id)
                ->whereBetween('invoiceDate',[$dateIni,$dateOut])->sum('amount');
            $pdf  .= Fpdf::Cell(20,6,number_format($expense,2),1,0,'C');
            $totalGtoM += $expense;

            if($departament->name == 'Fondos de Iglesia'):
                $difMonth=  ($income+$partIgl)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                endif;

            elseif($departament->name == 'Asociacion Central'):
                $difMonth=  ($income+$partAsoc)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                endif;
            else:
                $difMonth=  ($income)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,0,'C');
                endif;
            endif;
            $pdf   = Fpdf::SetFont('Arial','',8);
            /*--------------------------------------------- Igresos Acumulado----------------------------------*/
            $date = new Carbon($dateIni);
            $year = $date->format('Y');
            $income =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->whereBetween('incomes.date',[$year.'-01-01',$year.'-12-31'])
                ->where('departament_id',$departament->id)->where('part','no')->sum('incomes.balance');
            $incomePart =$this->incomeRepository->getModel()
                ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                ->whereBetween('incomes.date',[$year.'-01-01',$year.'-12-31'])
                ->where('departament_id',$departament->id)->where('part','si')->sum('incomes.balance');

            $totalIngA += $income+$incomePart;
            $partAsocAcum +=($incomePart/5)*2;
            $partIgl =    ($incomePart/5)*3;
            if($departament->name == 'Fondos de Iglesia'):
                $pdf  .= Fpdf::Cell(25,6,number_format($income+$partIgl,2),1,0,'C');
            elseif($departament->name == 'Asociacion Central'):
                $pdf  .= Fpdf::Cell(25,6,number_format($income+$partAsocAcum,2),1,0,'C');
            else:
                $pdf  .= Fpdf::Cell(25,6,number_format($income,2),1,0,'C');
            endif;
            /*--------------------------------------------- Gastos Acumulado----------------------------------*/
            $expense =$this->expensesRepository->getModel()
                ->join('type_expenses','type_expenses.id','=','expenses.type_expense_id')
                ->whereBetween('invoiceDate',[$year.'-01-01',$year.'-12-31'])
                ->where('departament_id',$departament->id)->sum('expenses.amount');
            $pdf  .= Fpdf::Cell(25,6,number_format($expense,2),1,0,'C');

            if($departament->name == 'Fondos de Iglesia'):
                $difMonth=  ($income+$partIgl)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,1,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,1,'C');
                endif;
            else:
                $difMonth=  ($income)-$expense;
                if($difMonth < 0):
                    $pdf  .= Fpdf::SetTextColor(249,50,0);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,1,'C');
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                else:
                    $pdf  .= Fpdf::SetTextColor(14,15,15);
                    $pdf  .= Fpdf::Cell(20,6,number_format($difMonth,2),1,1,'C');
                endif;
            endif;


        endforeach;
       /* $pdf  .= Fpdf::SetX(10);
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('TOTAL'),1,0,'R');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalPres),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalIngMAnt),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalGtoMAnt),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalIngMAnt-$totalGtoMAnt),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalIngM),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalGtoM),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalIngM-$totalGtoM),1,0,'C');
        $pdf  .= Fpdf::Cell(25,7,number_format($totalIngA),1,0,'C');
        $pdf  .= Fpdf::Cell(25,7,number_format($totalGtoA),1,0,'C');
        $pdf  .= Fpdf::Cell(20,7,number_format($totalIngA-$totalGtoA),1,1,'C');*/



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
        $date = new Carbon($dateIni);
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',16);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Fondos de Asociación'),0,1,'C');
        $pdf   = Fpdf::Ln();
        $asociacion = $this->typeExpenseRepository->oneWhere('name','Fondos Asociación Diezmo, 20% 20%');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode($date->format('F')),0,1,'C');
        $pdf   = Fpdf::Ln();
        $asocAmountMonth= $this->incomeRepository->Campo($dateIni,$dateOut);
        $pdf   .= Fpdf::SetX(20);

        $pdf  .= Fpdf::Cell(80,5,utf8_decode('Dep. Del Mes '.$date->format('M').': '.number_format($asocAmountMonth,2)),0,0,'L');
        $date = new Carbon($dateIni);
        $year = $date->format('Y') ;

        $asocAmountMonth= $this->incomeRepository->Campo($year.'-01-01',$dateOut);
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
            if($typeIncome->association == 'si'):
                $pdf   = Fpdf::SetFont('Arial','',12);




                $pdf   .= Fpdf::SetX(20);
                $pdf  .= Fpdf::Cell(40,7,utf8_decode($typeIncome->name),0,0,'L');
                $acum = $this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)->whereBetween('date',[$year.'-01-01',$dateOut])->sum('balance');

                $income =$this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)
                    ->whereBetween('date',[$dateIni,$dateOut])->sum('balance');
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
                /**************************************************************************************************/
                $totalIncome = $this->incomeRepository->getModel()
                    ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                    ->where('association','si')->where('date','>=',$dateIni)
                    ->where('date','<=',$dateOut)->sum('incomes.balance');
                if($income>0):
                    $pdf  .= Fpdf::Cell(40,7,number_format(($income/$totalIncome)*100,2).'%',0,0,'C');
                else:
                    $pdf  .= Fpdf::Cell(40,7,number_format(0,2).'%',0,0,'C');
                endif;
                /**************************************************************************************************/
                $totalAcum = $this->incomeRepository->getModel()
                    ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                    ->where('association','si')->whereBetween('date',[$year.'-01-01',$dateOut])->sum('incomes.balance');
                if($acum>0):
                    $pdf  .= Fpdf::Cell(35,7,number_format(($acum/$totalAcum)*100,2).'%',0,1,'C');
                else:
                    $pdf  .= Fpdf::Cell(35,7,number_format(0,2).'%',0,1,'C');
                endif;
            endif;
        endforeach;

        $pdf .= Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','I',12);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Saldo Bancos al 27 de Mayo Banco Nacional: 2,137,361.57'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Saldo Bancos al 27 de Mayo Banco Costa Rica: 318,606.59'),0,1,'C');
        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Total Saldo Bancos al 27 de Mayo: 2,455,968.16'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('_________________________________________'),0,1,'C');
        $pdf   = Fpdf::SetFont('Arial','I',12);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Aislante: 1,200,962.78'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Equipo de Sonido: 130,025.00'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Aula Infantes: 122,920.44'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Dorcas: 353,645.00'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Aventurero: 88,705.00'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Aire Acondicionado: 38,925.00'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Retiro Jovenes: 28,000.00'),0,1,'C');
        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('_________________________________________'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Total Fondos Asignados: 1,963,183.22'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('_________________________________________'),0,1,'C');
        $pdf   = Fpdf::SetFont('Arial','I',12);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Asociación Central: 0'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('_________________________________________'),0,1,'C');
        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Sub Total: 492,784.94'),0,1,'C');
        $pdf   = Fpdf::SetFont('Arial','I',12);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Presupuesto Departamentos Disponible: 210,000.00'),0,1,'C');
        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('_________________________________________'),0,1,'C');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Saldo Disponible: 282,784.94'),0,1,'C');
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
        $dateT = new Carbon($dateIni);
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Tipo de Ingreso'),1,0,'L');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Mes '.$dateT->subMonth(1)->format('M')),1,0,'C');
        $dateT = new Carbon($dateIni);
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Mes '.$dateT->format('M')),1,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('% Mes '.$dateT->format('M')),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Decrec/Creci'),1,1,'C');
        $typeIncomes = $this->typeIncomeRepository->allData();
        $totalInco=0;
        $totalAcum=0;
        $total =0;
        foreach($typeIncomes As $typeIncome):
            $pdf   = Fpdf::SetFont('Arial','',12);
            $dateAnterio = new Carbon($dateIni);

            $pdf   .= Fpdf::SetX(20);
            $pdf  .= Fpdf::Cell(40,7,utf8_decode($typeIncome->name),1,0,'L');
            /***********************************************************************************************/
            $incomeAnterior =$this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)
                ->where('date','>=',$dateAnterio->subMonth(1)->format('Y-m-d'))->where('date','<=',$dateAnterio->endOfMonth()->format('Y-m-d'))->sum('balance');
            $pdf  .= Fpdf::Cell(35,7,number_format($incomeAnterior,2),1,0,'C');
            $totalInco += $incomeAnterior;
            /***********************************************************************************************/
            $income =$this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)
                ->whereBetween('date',[$dateIni,$dateOut])->sum('balance');
            $pdf  .= Fpdf::Cell(35,7,number_format($income,2),1,0,'C');
            $totalAcum += $income;
            /***********************************************************************************************/
            $totalIncome = $this->incomeRepository->getModel()->where('date','>=',$dateIni)
                ->where('date','<=',$dateOut)->sum('balance');
            if($income>0):
                $pdf  .= Fpdf::Cell(40,7,number_format(($income/$totalIncome)*100,2).'%',1,0,'C');
            else:
                $pdf  .= Fpdf::Cell(40,7,number_format(0,2).'%',1,0,'C');
            endif;
            /***********************************************************************************************/
            $pdf  .= Fpdf::Cell(35,7,number_format(($income-$incomeAnterior),2),1,1,'C');

            $total += $income-$incomeAnterior;
        endforeach;

        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf   .= Fpdf::SetX(20);
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Total'),1,0,'L');
        $pdf  .= Fpdf::Cell(35,7,number_format($totalInco,2),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,number_format($totalAcum,2),1,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('100%'),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,number_format($total,2),1,1,'C');

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