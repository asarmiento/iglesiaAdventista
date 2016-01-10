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
     * ReportController constructor.
     * @param Fpdf $fpdf
     * @param TypeFixedRepository $typeFixedRepository
     * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     * @param TypeExpense $typeExpense
     * @param IncomeRepository $incomeRepository
     */
    public function __construct(
        Fpdf $fpdf,
        TypeFixedRepository $typeFixedRepository,
        TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository,
        TypeExpense $typeExpense,
        IncomeRepository $incomeRepository

    )
    {

        $this->fpdf = $fpdf;
        $this->typeFixedRepository = $typeFixedRepository;
        $this->typeTemporaryIncomeRepository = $typeTemporaryIncomeRepository;
        $this->typeExpense = $typeExpense;
        $this->incomeRepository = $incomeRepository;
    }
    public function index()
    {
        return view('report.index');
    }


    public function store()
    {


        $this->header();
        $pdf    = Fpdf::SetFont('Arial','B',14);
        $pdf   .= Fpdf::Cell(0,7,utf8_decode('Ingresos'),0,1,'C');

        $fixs = $this->typeFixedRepository->allData();
        $pdf  .= Fpdf::Cell(50,7,utf8_decode('Rubro'),0,0,'L');
        $pdf  .= Fpdf::Cell(10,7,utf8_decode('Ingresos'),0,0,'L');
        $pdf  .= Fpdf::Cell(10,7,utf8_decode('Salidas'),0,1,'L');
        foreach($fixs AS $fix):
            $pdf    = Fpdf::SetFont('Arial','',12);
            $income = DB::select('SELECT SUM(balance) FROM `incomes` WHERE `typeFixedIncome_id`= '.$fix->id);
            $expense = DB::select('SELECT SUM(amount) FROM `expense_income` WHERE `type_fixed_income_id`= '.$fix->id);

            $pdf  .= Fpdf::Cell(50,7, utf8_decode($fix->name),0,0,'L');

            $pdf  .= Fpdf::Cell(10,7, number_format($income,2),0,0,'L');

            $pdf  .= Fpdf::Cell(10,7, number_format($expense,2),0,1,'L');
        endforeach;

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
    public function header()
    {
        $pdf  = Fpdf::AddPage();
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('IGLESIA ADVENTISTA DE QUEPOS'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Cell(0,7,'INFORME DE INGREOS Y GASTOS',0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,'2015',0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Ln();

        return $pdf;
    }
}