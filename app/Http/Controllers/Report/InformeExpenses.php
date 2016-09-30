<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 05/04/16
 * Time: 06:27 PM
 */

namespace SistemasAmigables\Http\Controllers\Report;


use Anouar\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;

class InformeExpenses extends Controller
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
     * @var ExpensesRepository
     */
    private $expensesRepository;
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;

    public function __construct(
        MemberRepository $memberRepository,
        IncomeRepository $incomeRepository,
        TypeExpenseRepository $typeExpenseRepository,
        ExpensesRepository $expensesRepository,
        DepartamentRepository $departamentRepository,
        TypeIncomeRepository $typeIncomeRepository
    )
    {

        $this->memberRepository = $memberRepository;
        $this->incomeRepository = $incomeRepository;
        $this->typeExpenseRepository = $typeExpenseRepository;
        $this->expensesRepository = $expensesRepository;
        $this->departamentRepository = $departamentRepository;
        $this->typeIncomeRepository = $typeIncomeRepository;
    }
    public function index(){
        $year = Input::get('year');

        $pdf = Fpdf::Ln();

        if(Input::get('tipo') == '1-1'):
            $this->header('L');
            $this->gastosAll($year);
        elseif(Input::get('departament') == '1-2'):
            $this->header('L');
            $this->departament($year);
        elseif(Input::get('tipo') == '1-3'):
            $this->header('P');
            $this->gastoMonth($year);
        else:
            $this->header('P');

            $this->notOfrendas($year,Input::get('tipo'));
        endif;

        Fpdf::Output('Informe-Semana.pdf','I');
        exit;
    }
    public function gastoMonth($year){

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
    public function departament($year)
    {
        $pdf = Fpdf::Ln();
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Año: '.$year),1,0,'C');
        $pdf = Fpdf::Ln();
        $pdf = Fpdf::SetFont('Arial','B',10);
        $pdf .= Fpdf::Cell(5,7,utf8_decode('N°'),1,0,'C');
        $pdf .= Fpdf::Cell(40,7,utf8_decode('Departamento'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ene'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Feb'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Mar'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Abr'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('May'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Jun'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Jul'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ago'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Sep'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Oct'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Nov'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Dic'),1,0,'C');
        $pdf .= Fpdf::Cell(20,7,utf8_decode('Total'),1,0,'C');
        $pdf .= Fpdf::Cell(14,7,utf8_decode('%'),1,1,'C');



        $i=0;
        $departaments = $this->departamentRepository->getModel()->where('type','iglesia')->orderBy('name','ASC')->get();
        $departamen = $this->departamentRepository->getModel()->where('type','iglesia')->orderBy('name','ASC')->lists('id');
        $typesList = $this->typeExpenseRepository->getModel()->whereIn('departament_id',$departamen)->lists('id');
        $mes = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        foreach($departaments AS $key=>$departament): $i++;

        $total=0;
            $pdf = Fpdf::SetFont('Arial','B',8);
            $pdf .= Fpdf::Cell(5,7,$key+1,1,0,'L');
            $pdf .= Fpdf::Cell(40,7,substr(utf8_decode(ucwords(strtolower($departament->name))),0,33),1,0,'L');
            $types = $this->typeExpenseRepository->getModel()->where('departament_id',$departament->id)->lists('id');
            $totalDie=0;
            $pdf = Fpdf::SetFont('Arial','I',8);
            for($i=0;$i<count($mes);$i++):
                $gasto = $this->expensesRepository->getModel()->whereIn('type_expense_id',$types)
                    ->whereBetween('invoiceDate',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('amount');
                $totalDie += $gasto;
                $pdf .= Fpdf::Cell(15,7,number_format($gasto),1,0,'C');
            endfor;
            $pdf = Fpdf::SetFont('Arial','BI',8);
            $pdf .= Fpdf::Cell(20,7,number_format($totalDie,2),1,0,'C');
            $total = $this->expensesRepository->getModel()->whereIn('type_expense_id',$typesList)
                ->whereBetween('invoiceDate',[$year.'-01-01',$year.'-12-31'])->sum('amount');
            $percent = ($totalDie/$total)*100;
            $pdf .= Fpdf::Cell(14,7,number_format($percent).'%',1,0,'C');
            $pdf .= Fpdf::Ln();
        endforeach;
        $pdf = Fpdf::SetFont('Arial','B',8);
        $pdf .= Fpdf::Cell(45,7,utf8_decode('Total'),1,0,'L');
        $pdf = Fpdf::SetFont('Arial','BI',7.5);
        for($i=0;$i<count($mes);$i++):
            $gasto = $this->expensesRepository->getModel()->whereHas('typeExpense',function($q){
                $q->where('type','iglesia');
            })->whereBetween('invoiceDate',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('amount');
            $totalDie += $gasto;
            $pdf .= Fpdf::Cell(15,7,number_format($gasto,2),1,0,'C');
        endfor;
        $pdf .= Fpdf::Cell(20,7,number_format($totalDie,2),1,0,'C');
        $percent = ($totalDie/$total)*100;
        $pdf .= Fpdf::Cell(14,7,number_format(100).'%',1,0,'C');
        Fpdf::Output('Informe-de-gastos.pdf','I');
        exit;
    }


    public function gastosAll($year)
    {
        $pdf = Fpdf::Ln();
        $pdf = Fpdf::SetFont('Arial','B',10);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('AÑO: '.$year),1,1,'C');
        $pdf .= Fpdf::Cell(55,7,utf8_decode('Tipo de Gasto'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ene'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Feb'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Mar'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Abr'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('May'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Jun'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Jul'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Ago'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Sep'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Oct'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Nov'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Dic'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('Total'),1,0,'C');
        $pdf .= Fpdf::Cell(15,7,utf8_decode('%'),1,1,'C');




        $types = $this->typeExpenseRepository->getModel()->where('type','iglesia')->get();
        $typesList = $this->typeExpenseRepository->getModel()->where('type','iglesia')->lists('id');

        $mes = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $total=0;
        $graTotal=0;
        foreach($types AS $type):
            $totalDie=0;


            $pdf = Fpdf::SetFont('Arial','B',8);
            $pdf .= Fpdf::Cell(55,7,substr(utf8_decode(ucwords(strtolower($type->name))),0,33),1,0,'L');
            $pdf = Fpdf::SetFont('Arial','I',8);

            for($i=0;$i<count($mes);$i++):

                $gasto = $this->expensesRepository->getModel()->where('type_expense_id',$type->id)
                    ->whereBetween('invoiceDate',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('amount');
                $totalDie += $gasto;
                $pdf .= Fpdf::Cell(15,7,number_format($gasto),1,0,'C');


            endfor;

            $pdf .= Fpdf::Cell(15,7,number_format($totalDie),1,0,'C');
            $total = $this->expensesRepository->getModel()->whereIn('type_expense_id',$typesList)
                ->whereBetween('invoiceDate',[$year.'-01-01',$year.'-12-31'])->sum('amount');

            $percent = ($totalDie/$total)*100;
            $pdf .= Fpdf::Cell(15,7,number_format($percent,2).'%',1,1,'C');

        endforeach;
        $pdf .= Fpdf::Cell(55,7,'Total',1,0,'R');
        for($i=0;$i<count($mes);$i++):

            $gasto = $this->expensesRepository->getModel()->whereIn('type_expense_id',$typesList)
                ->whereBetween('invoiceDate',[$year.'-'.$mes[$i].'-01',$year.'-'.$mes[$i].'-31'])->sum('amount');
            $totalDie += $gasto;
            $pdf .= Fpdf::Cell(15,7,number_format($gasto),1,0,'C');
            $graTotal += $gasto;
        endfor;
        $pdf .= Fpdf::Cell(30,7,number_format($graTotal,2),1,1,'C');
        $pdf .= Fpdf::Ln();
        $pdf .= Fpdf::Cell(55,7,'Promedio de Gasto por mes',1,0,'R');
        $pdf .= Fpdf::Cell(30,7,number_format($graTotal/12,2),1,1,'C');
        Fpdf::Output('Informe-de-gastos.pdf','I');
        exit;
    }

    public function header($t)
    {
        $pdf  = Fpdf::AddPage($t,'letter');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Apartado 10113-1000 San José, Costa Rica'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Teléfonos: 2224-8311 Fax:2225-0665'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Informe de Gastos Iglesia de Quepos'),0,1,'C');
        return $pdf;
    }
}