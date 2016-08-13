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
use SistemasAmigables\Repositories\PeriodRepository;
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
     * @var PeriodRepository
     */
    private $periodRepository;

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
     * @param PeriodRepository $periodRepository
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
        RecordRepository $recordRepository,
        PeriodRepository $periodRepository
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
        $this->periodRepository = $periodRepository;
    }
    public function index()
    {
        return view('report.index');
    }


    public function store($date)
    {
        $date = new Carbon($date);
        $fixs = $this->typeIncomeRepository->getModel()->whereHas('incomes',function ($q) use ($date){
            $q->where('date',$date->format('Y-m-d'));
        })->count();
        if($fixs <= 9):
            $orientacion = 'P';
        else:
                $orientacion = 'L';
        endif;
        $this->header($date->format('Y-m-d'),$orientacion);
        $pdf    = Fpdf::SetFont('Arial','B',7);
        $pdf    .= Fpdf::SetX(5);
        $pdf  .= Fpdf::Cell(5,7,utf8_decode('N°'),1,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Nombres'),1,0,'C');
        $pdf  .= Fpdf::Cell(13,7,utf8_decode('Recibo N°'),1,0,'C');
        $pdf  .= Fpdf::Cell(13,7,utf8_decode('Total'),1,0,'C');
        $i=0;
        $fixs = $this->typeIncomeRepository->getModel()->whereHas('incomes',function ($q) use ($date){
            $q->where('date',$date->format('Y-m-d'));
        })->get();
        foreach($fixs AS $fix): $i++;
           $pdf  .= Fpdf::Cell(13,7,substr(utf8_decode($fix->abreviation),0,8),1,0,'C');
        endforeach;
        $pdf  .= Fpdf::ln();
        $e =0;
        $fin = 0;
        $pdf  .= Fpdf::SetFont('Arial','I',7);
        /* INICIO DE CUERPO */
        $miembros = $this->memberRepository->getModel()->whereHas('incomes',function ($q) use ($date){
            $q->where('date',$date->format('Y-m-d'))->orderBy('id','ASC');
        })->get();
        foreach($miembros AS $miembro):
            $e++;
            $pdf  .= Fpdf::SetX(5);
            $pdf  .= Fpdf::Cell(5,7,utf8_decode($e),1,0,'C');
            $pdf  .= Fpdf::Cell(40,7,substr(utf8_decode($miembro->completo()),0,30),1,0,'L');
            $numberOf = $this->incomeRepository->incomeDateMember($miembro->id,$date->format('Y-m-d'))->get();
            $pdf  .= Fpdf::Cell(13,7,$numberOf[0]->numberOf,1,0,'C');
            $total = $numberOf = $this->incomeRepository->incomeDateMember($miembro->id,$date->format('Y-m-d'))->sum('balance');
            $fin += $total;
            $pdf  .= Fpdf::Cell(13,7,number_format($total,2),1,0,'C');

            foreach($fixs AS $fix):
                $amount = $this->incomeRepository->incomeDateMember($miembro->id,$date->format('Y-m-d'))->where('type_income_id',$fix->id)->sum('balance');
                $pdf  .= Fpdf::Cell(13,7,number_format($amount,2),1,0,'C');
            endforeach;
            $pdf  .= Fpdf::ln();
        endforeach;
        /*fIN DE CUERPO*/
        $pdf  .= Fpdf::SetFont('Arial','B',6.5);
        $pdf  .= Fpdf::SetX(5);
        $pdf  .= Fpdf::Cell(58,7,'TOTALES _  _  _  _  _  _',0,0,'R');
        $pdf  .= Fpdf::Cell(13,7,number_format($fin,2),1,0,'R');
        foreach($fixs AS $fix):
            $amount=  $this->incomeRepository->twoWhereList('type_income_id',$fix->id,'date',$date->format('Y-m-d'),'balance');
           $pdf  .= Fpdf::Cell(13,7,number_format($amount,2),1,0,'C');
        endforeach;
        $pdf  .= Fpdf::ln();
        $pdf  .= Fpdf::ln();
        $y     = Fpdf::GetY();
        $pdf .= $this->firmas($orientacion,$date);
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
    public function firmas($orientacion,$date)
    {
        $y = Fpdf::GetY();
        if($orientacion == 'L' && $y > 150):
            $y = $y+170;
        endif;

        $pdf = Fpdf::SetXY(90,$y);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('______________________________'),0,1,'L');
        $pdf = Fpdf::SetX(90);
        $pdf  .= Fpdf::Cell(40,5,utf8_decode('Tesorero'),0,1,'C');
        $pdf = Fpdf::SetX(90);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('______________________________'),0,1,'L');
        $pdf = Fpdf::SetX(90);
        $pdf  .= Fpdf::Cell(40,5,utf8_decode('Pastor o Anciano'),0,1,'C');
        $pdf = Fpdf::SetX(90);
        $pdf  .= Fpdf::Cell(30,5,utf8_decode('______________________________'),0,1,'L');
        $pdf = Fpdf::SetX(90);
        $pdf  .= Fpdf::Cell(40,5,utf8_decode('Dir. Mayordomia o Diacono'),0,1,'C');
        $fixs = $this->typeIncomeRepository->getModel()->whereHas('incomes',function ($q) use ($date){
            $q->where('date',$date->format('Y-m-d'));
        })->get();
        foreach($fixs AS $fix):
            $pdf .= Fpdf::SetXY(135,$y);
            $pdf  .= Fpdf::Cell(13,5,utf8_decode($fix->abreviation).' = '.utf8_decode($fix->name),0,1,'L');
            $y +=5;
        endforeach;

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


        $pdf  = Fpdf::AddPage('P','letter');
        $this->headerInforme();
        $this->promedios();
       $pdf  = Fpdf::AddPage('P','letter');
        $this->headerInforme();
     //  $pdf  .= Fpdf::Cell(0,5,utf8_decode($dateIni.' al '.$dateOut),0,1,'C');

       $this->ingresos();
     //  $pdf  = Fpdf::AddPage('P','letter');
     //   $this->headerInforme();
      //  $this->association($dateIni,$dateOut);
        $pdf  = Fpdf::AddPage('L','letter');
        $this->headerInforme();
        $this->departament();

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
    public function promedios()
    {
        $token = $this->convertionObjeto();
        $period = $this->periodRepository->token($token['periods']);
        $beforePeriodo = $this->periodRepository->before($period);
        $pdf   = Fpdf::Ln();

        $departaments = $this->departamentRepository->getModel()->where('type','iglesia')->orderBy('budget','DESC')->get();
        $i=0;
        foreach($departaments As $departament):
            $pdf   = Fpdf::SetFont('Arial','B',16);
            $i++;
            if($departament->budget > 0):
                $pdf   .= Fpdf::SetX(10);
                $pdf  .= Fpdf::Cell(7,6,utf8_decode($i),0,0,'L');
                $pdf  .= Fpdf::Cell(60,6,utf8_decode($departament->name),0,0,'L');
                $pdf  .= Fpdf::Cell(20,6,(number_format($departament->budget,2)*100).'%',0,0,'C');
                $pdf  .= Fpdf::Cell(35,6,(number_format($departament->balance,2)),0,1,'C');
                $pdf   .= Fpdf::Ln();
                $typeIncomes = $this->typeIncomeRepository->getModel()->whereHas('incomes',function ($q) use ($period){
                    $q->whereBetween('date',[$period->dateIn,$period->dateOut]);
                })
                    ->where('departament_id',$departament->id)->get();
                $e=0;
                foreach($typeIncomes As $typeIncome): $e++;
                    if($typeIncome->balance > 0):
                    $pdf   = Fpdf::SetFont('Arial','I',14);
                    $i++;
                       $pdf   .= Fpdf::SetX(20);
                        $pdf  .= Fpdf::Cell(7,6,utf8_decode($e),0,0,'L');
                        $pdf  .= Fpdf::Cell(100,6,utf8_decode($typeIncome->name),0,0,'L');
                        $pdf  .= Fpdf::Cell(35,6,(number_format($typeIncome->balance,2)),0,0,'C');
                        $pdf  .= Fpdf::Cell(35,6,('Ingreso'),0,1,'C');
                        endif;
                    endforeach;
                $pdf   .= Fpdf::Ln();
                $typeExpenses = $this->typeExpenseRepository->getModel()->whereHas('expenses',function ($q) use ($period){
                    $q->whereBetween('invoiceDate',[$period->dateIn,$period->dateOut]);
                })->where('departament_id',$departament->id)->get();
                $f =0;
                foreach($typeExpenses As $typeExpense): $f++;
                    if($typeExpense->balance > 0):
                    $pdf   = Fpdf::SetFont('Arial','I',14);
                    $i++;
                    $pdf   .= Fpdf::SetX(20);
                    $pdf  .= Fpdf::Cell(7,6,utf8_decode($f),0,0,'L');
                    $pdf  .= Fpdf::Cell(100,6,utf8_decode($typeExpense->name),0,0,'L');
                    $pdf  .= Fpdf::Cell(35,6,(number_format($typeExpense->balance,2)),0,0,'C');
                    $pdf  .= Fpdf::Cell(35,6,('Gasto'),0,1,'C');
                    endif;
                endforeach;
            endif;
        endforeach;
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
    public function departament()
    {

        $token = $this->convertionObjeto();
        $period = $this->periodRepository->token($token['periods']);
        $beforePeriodo = $this->periodRepository->before($period);

        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',16);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Departamentos de la Iglesia'),0,1,'C');
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',12);
        $pdf  .= Fpdf::SetX(10);
        $pdf  .= Fpdf::Cell(7,7,utf8_decode('N°'),1,0,'L');
        $pdf  .= Fpdf::Cell(37,7,utf8_decode('Departamentos'),1,0,'L');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('presup.'),1,0,'C');

        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Saldo Dispo'),1,0,'C');
        $date = new Carbon($beforePeriodo->dateIn);
        $pdf  .= Fpdf::Cell(81,7,utf8_decode('Mes '.$date->subMonth(1)->format('M')),1,0,'C');
        $date = new Carbon($period->dateIn);
        $pdf  .= Fpdf::Cell(81,7,utf8_decode('Mes '.$date->format('M')),1,1,'C');
        $pdf  .= Fpdf::SetX(109);
        $pdf  .= Fpdf::Cell(27,7,utf8_decode('Ing.'),1,0,'C');
        $pdf  .= Fpdf::Cell(27,7,utf8_decode('Gto'),1,0,'C');
        $pdf  .= Fpdf::Cell(27,7,utf8_decode('Dif.'),1,0,'C');
        $pdf  .= Fpdf::Cell(27,7,utf8_decode('Ing.'),1,0,'C');
        $pdf  .= Fpdf::Cell(27,7,utf8_decode('Gto'),1,0,'C');
        $pdf  .= Fpdf::Cell(27,7,utf8_decode('Dif.'),1,1,'C');

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
        $departaments = $this->departamentRepository->getModel()->orderBy('budget','DESC')->get();
        $i=0;
        foreach($departaments As $departament):
        $i++;

            $pdf   = Fpdf::SetFont('Arial','',9);


            if($departament->budget>0):
            $pdf   .= Fpdf::SetX(10);
            $pdf  .= Fpdf::Cell(7,6,utf8_decode($i),1,0,'L');
            $pdf  .= Fpdf::Cell(37,6,utf8_decode($departament->name),1,0,'L');
            $pdf  .= Fpdf::Cell(20,6,(number_format($departament->budget,2)*100).'%',1,0,'C');
            $pdf  .= Fpdf::Cell(35,6,(number_format($departament->balance,2)),1,0,'C');
                $partAsocAnt += $departament->balance;
                $pdf   = Fpdf::SetFont('Arial','',8);
            $InDepBef = $this->incomeRepository->getModel()->whereHas('typeIncomes',function ($q) use ($departament){
                    $q->where('departament_id',$departament->id);
                })->whereBetween('date',[$beforePeriodo->dateIn,$beforePeriodo->dateOut])->sum('balance');
                $totalIngMAnt += $InDepBef;
            $pdf  .= Fpdf::Cell(27,6,(number_format($InDepBef,2)),1,0,'C');
            $OutDepBef = $this->expensesRepository->getModel()->whereHas('typeExpense',function ($q) use ($departament){
                    $q->where('departament_id',$departament->id);
                })->whereBetween('invoiceDate',[$beforePeriodo->dateIn,$beforePeriodo->dateOut])->sum('amount');
                $totalGtoMAnt += $OutDepBef;
                $pdf  .= Fpdf::Cell(27,6,(number_format($OutDepBef,2)),1,0,'C');
                if(($InDepBef-$OutDepBef) >= 0):
                    $pdf  .= Fpdf::Cell(27,6,(number_format($InDepBef-$OutDepBef,2)),1,0,'C');
                else:
                    $pdf  .= Fpdf::SetTextColor(242,75,3);
                    $pdf  .= Fpdf::Cell(27,6,(number_format($InDepBef-$OutDepBef,2)),1,0,'C');
                    $pdf  .= Fpdf::SetTextColor(0,0,0);
                endif;
                /***********************************************************************************************************************/
                $InDepBef = $this->incomeRepository->getModel()->whereHas('typeIncomes',function ($q) use ($departament){
                    $q->where('departament_id',$departament->id);
                })->whereBetween('date',[$period->dateIn,$period->dateOut])->sum('balance');
                $totalIngM += $InDepBef;
                $pdf  .= Fpdf::Cell(27,6,(number_format($InDepBef,2)),1,0,'C');
                $OutDepBef = $this->expensesRepository->getModel()->whereHas('typeExpense',function ($q) use ($departament){
                    $q->where('departament_id',$departament->id);
                })->whereBetween('invoiceDate',[$period->dateIn,$period->dateOut])->sum('amount');

                $totalGtoM += $OutDepBef;
                $pdf  .= Fpdf::Cell(27,6,(number_format($OutDepBef,2)),1,0,'C');
                if(($InDepBef-$OutDepBef) >= 0):
                    $pdf  .= Fpdf::Cell(27,6,(number_format($InDepBef-$OutDepBef,2)),1,1,'C');
                else:
                    $pdf  .= Fpdf::SetTextColor(242,75,3);
                    $pdf  .= Fpdf::Cell(27,6,(number_format($InDepBef-$OutDepBef,2)),1,1,'C');
                    $pdf  .= Fpdf::SetTextColor(0,0,0);
                endif;
            $totalPres +=$departament->budget;

            endif;
        endforeach;
        $pdf  .= Fpdf::SetX(10);
        $pdf  .= Fpdf::Cell(44,7,utf8_decode('TOTAL'),1,0,'R');
        $pdf  .= Fpdf::Cell(20,7,utf8_decode('100%'),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,number_format($partAsocAnt,2),1,0,'C');
        $pdf  .= Fpdf::Cell(27,7,number_format($totalIngMAnt),1,0,'C');
        $pdf  .= Fpdf::Cell(27,7,number_format($totalGtoMAnt),1,0,'C');
        if(($totalIngMAnt-$totalGtoMAnt) >= 0):
            $pdf  .= Fpdf::Cell(27,7,number_format($totalIngMAnt-$totalGtoMAnt),1,0,'C');

        else:
            $pdf  .= Fpdf::SetTextColor(242,75,3);
            $pdf  .= Fpdf::Cell(27,7,number_format($totalIngMAnt-$totalGtoMAnt),1,0,'C');
            $pdf  .= Fpdf::SetTextColor(0,0,0);
        endif;
        $pdf  .= Fpdf::Cell(27,7,number_format($totalIngM),1,0,'C');
        $pdf  .= Fpdf::Cell(27,7,number_format($totalGtoM),1,0,'C');
        if(($totalIngM-$totalGtoM) >= 0):
            $pdf  .= Fpdf::Cell(27,7,number_format($totalIngM-$totalGtoM),1,1,'C');
        else:
            $pdf  .= Fpdf::SetTextColor(242,75,3);
            $pdf  .= Fpdf::Cell(27,7,number_format($totalIngM-$totalGtoM),1,1,'C');
            $pdf  .= Fpdf::SetTextColor(0,0,0);
        endif;


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
    public function association()
    {
        $token = $this->convertionObjeto();
        $period = $this->periodRepository->token($token['periods']);
        $beforePeriodo = $this->periodRepository->before($period);


        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',16);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Fondos de Asociación'),0,1,'C');
        $pdf   = Fpdf::Ln();
        $asociacion = $this->typeExpenseRepository->oneWhere('name','Fondos Asociación Diezmo, 20% 20%');
        $pdf  .= Fpdf::Cell(0,5,utf8_decode(''),0,1,'C');
        $pdf   = Fpdf::Ln();
        $asocAmountMonth= $this->incomeRepository->Campo($period->dateIn,$period->dateOut);
        $pdf   .= Fpdf::SetX(20);

        $pdf  .= Fpdf::Cell(80,5,utf8_decode('Dep. Del Mes '.$period->dateIn.': '.number_format($asocAmountMonth,2)),0,0,'L');


        $asocAmountMonth= $this->incomeRepository->Campo($period->year.'-01-01',$period->dateOut);
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
                $acum = $this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)->whereBetween('date',[$period->year.'-01-01',$period->dateOut])->sum('balance');

                $income =$this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)
                    ->whereBetween('date',[$period->dateIn,$period->dateOut])->sum('balance');
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
                    ->where('date','<=',$period->dateOut)->sum('incomes.balance');
                if($income>0):
                    $pdf  .= Fpdf::Cell(40,7,number_format(($income/$totalIncome)*100,2).'%',0,0,'C');
                else:
                    $pdf  .= Fpdf::Cell(40,7,number_format(0,2).'%',0,0,'C');
                endif;
                /**************************************************************************************************/
                $totalAcum = $this->incomeRepository->getModel()
                    ->join('type_incomes','type_incomes.id','=','incomes.type_income_id')
                    ->where('association','si')->whereBetween('date',[$year.'-01-01',$period->dateOut])->sum('incomes.balance');
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
    public function ingresos()
    {
        $token = $this->convertionObjeto();
        $period = $this->periodRepository->token($token['periods']);
        $beforePeriodo = $this->periodRepository->before($period);

        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',16);
        $pdf  .= Fpdf::Cell(0,5,utf8_decode('Ingresos'),0,1,'C');

        $pdf   = Fpdf::Ln();
        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf   .= Fpdf::SetX(20);
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Tipo de Ingreso'),1,0,'L');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Mes '.$beforePeriodo->month.'-'.$beforePeriodo->year),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Mes '.$period->month.'-'.$period->year),1,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('% Mes '.$period->month.'-'.$period->year),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,utf8_decode('Decrec/Creci'),1,1,'C');
        $typeIncomes = $this->typeIncomeRepository->getModel()->whereHas('incomes',function ($q) use ($period){
            $q->whereBetween('date',[$period->dateIn,$period->dateOut]);
        })->get();

        $totalInco=0;
        $totalAcum=0;
        $total =0;
        foreach($typeIncomes As $typeIncome):
            $pdf   = Fpdf::SetFont('Arial','',12);
            $pdf  .= Fpdf::SetX(20);
            $pdf  .= Fpdf::Cell(40,7,utf8_decode($typeIncome->abreviation),1,0,'L');
            /***********************************************************************************************/
            $incomeAnt = $this->incomeRepository->ofrendaTypeIncome($typeIncome->id,[$beforePeriodo->dateIn,$beforePeriodo->dateOut]);
            $pdf   .= Fpdf::Cell(35,7,number_format($incomeAnt,2),1,0,'C');
            $totalInco += $incomeAnt;
           /***********************************************************************************************/
            $income = $this->incomeRepository->ofrendaTypeIncome($typeIncome->id,[$period->dateIn,$period->dateOut]);
            $pdf   .= Fpdf::Cell(35,7,number_format($income,2),1,0,'C');
            $totalAcum += $income;
            /***********************************************************************************************/
            $totalIncome = $this->incomeRepository->getModel()->whereBetween('date',[$period->dateIn,$period->dateOut])->sum('balance');
            if($income > 0):
                $pdf  .= Fpdf::Cell(40,7,number_format(($income/$totalIncome)*100,2).'%',1,0,'C');
            else:
                $pdf  .= Fpdf::Cell(40,7,number_format(0,2).'%',1,0,'C');
            endif;
            /***********************************************************************************************/
            if(($income-$incomeAnt) > 0):
            $pdf  .= Fpdf::Cell(35,7,number_format(($income-$incomeAnt),2),1,1,'C');
                else:
                    $pdf  .= Fpdf::SetTextColor(242,75,3);
                    $pdf  .= Fpdf::Cell(35,7,number_format(($income-$incomeAnt),2),1,1,'C');
                    $pdf  .= Fpdf::SetTextColor(0,0,0);
                    endif;
            $total += $income-$incomeAnt;
        endforeach;

        $pdf   = Fpdf::SetFont('Arial','B',14);
        $pdf   .= Fpdf::SetX(20);
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('Total'),1,0,'L');
       $pdf  .= Fpdf::Cell(35,7,number_format($totalInco,2),1,0,'C');
       $pdf  .= Fpdf::Cell(35,7,number_format($totalAcum,2),1,0,'C');
        $pdf  .= Fpdf::Cell(40,7,utf8_decode('100%'),1,0,'C');
        $pdf  .= Fpdf::Cell(35,7,number_format($total,2),1,1,'C');

        $pdf  .= Fpdf::Ln();

        foreach($typeIncomes As $typeIncome):
            $pdf  .= Fpdf::Cell(25,7,utf8_decode($typeIncome->abreviation ),0,0,'L');
            $pdf  .= Fpdf::Cell(5,7,utf8_decode('=' ),0,0,'L');
            $pdf  .= Fpdf::Cell(40,7,utf8_decode($typeIncome->name ),0,1,'L');
        endforeach;
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