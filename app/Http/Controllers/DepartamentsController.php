<?php namespace SistemasAmigables\Http\Controllers;

use Anouar\Fpdf\Facades\Fpdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Entities\Church;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\TransfersRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;

class DepartamentsController extends Controller {
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;
    /**
     * @var ExpensesRepository
     */
    private $expensesRepository;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var TypeIncomeRepository
     */
    private $typeIncomeRepository;
    /**
     * @var TypeExpenseRepository
     */
    private $typeExpenseRepository;
    /**
     * @var TransfersRepository
     */
    private $transfersRepository;

    /**
     * DepartamentsController constructor.
     * @param DepartamentRepository $departamentRepository
     * @param ExpensesRepository $expensesRepository
     * @param IncomeRepository $incomeRepository
     * @param TypeIncomeRepository $typeIncomeRepository
     * @param TypeExpenseRepository $typeExpenseRepository
     * @param TransfersRepository $transfersRepository
     */
    public function __construct(
        DepartamentRepository $departamentRepository,
        ExpensesRepository $expensesRepository,
        IncomeRepository $incomeRepository,
        TypeIncomeRepository $typeIncomeRepository,
        TypeExpenseRepository $typeExpenseRepository,
        TransfersRepository $transfersRepository
    )
    {

        $this->departamentRepository = $departamentRepository;
        $this->expensesRepository = $expensesRepository;
        $this->incomeRepository = $incomeRepository;
        $this->typeIncomeRepository = $typeIncomeRepository;
        $this->typeExpenseRepository = $typeExpenseRepository;
        $this->transfersRepository = $transfersRepository;
    }
    /**
     * Display a listing of departamentos
     *
     * @return Response
     */
    public function index() {


        $departaments = $this->departamentRepository->saldosIndex($this->dateSearch());
        $totalExpenses  = $this->expensesRepository->getModel()->sum('amount');
        $totalIncomes  = $this->incomeRepository->getModel()->sum('balance');
        $totalPresupuesto = $this->departamentRepository->getModel()->sum('budget');
        return View('departamentos.index', compact('departaments','totalExpenses','totalPresupuesto','totalIncomes'));
    }

    public function dateSearch()
    {
        $now = Carbon::now();
        $dateOut= $now->format('Y-m-d');
        $day = $now->format('d');
        $dateIn= $now->subDay(($day-1))->format('Y-m-d');
        $date= ['dateOut'=>$dateOut,'dateIn'=>$dateIn];
        return $date;
    }
    /**
     * Show the form for creating a new departamento
     *
     * @return Response
     */
    public function create() {
        $form_data = array('route' => 'depart-store', 'method' => 'POST');
        $action = 'Agregar';
        $departamentos = array();
        $church = Church::lists('id');
        return View('departamentos.form', compact('departamentos', 'action', 'form_data', 'church'));
    }

    /**
     * Store a newly created departamento in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), Departamento::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        Departamento::create($data);

        return Redirect::route('departamentos.index');
    }

    /**
     * Display the specified departamento.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $departamento = Departamento::findOrFail($id);

        return View::make('departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified departamento.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $departamento = Departamento::find($id);

        return View::make('departamentos.edit', compact('departamento'));
    }

    /**
     * Update the specified departamento in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $departamento = Departamento::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Departamento::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $departamento->update($data);

        return Redirect::route('departamentos.index');
    }

    /**
     * Remove the specified departamento from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Departamento::destroy($id);

        return Redirect::route('departamentos.index');
    }

    /**
     * ---------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
     * @Date Create: 2016-05-09
     * @Date Update: 2016-00-00
     * ---------------------------------------------------------------------
     * @Description: Mostramos la vista para seleccionar uno o todos los
     *  departamentos para ver los ingresos y gastos o ambos
     *
     * @Pasos:
     *
     *
     *
     *
     *
     *
     * ----------------------------------------------------------------------
     * @return mixed
     * ----------------------------------------------------------------------
     */
    public function moveDepartament()
    {
        $departaments = $this->departamentRepository->allData();
        return view('departamentos.movimientos', compact('departaments'));
    }

    /**
     * ---------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
     * @Date Create: 2016-05-09
     * @Date Update: 2016-00-00
     * ---------------------------------------------------------------------
     * @Description: Generaremos el reporte de pdf para todos los departaments
     * o de forma individual
     *
     * @Pasos:
     *
     *
     *
     *
     *
     *
     * ----------------------------------------------------------------------
     * @return mixed
     * ----------------------------------------------------------------------
     */
    public function storeDepartament(){
        $datos = Input::all();
        $this->header();
        if($datos['departament']=='1-2'):
            $pdf = Fpdf::Cell(0,7,utf8_decode('Informe movimientos x Departamento'),0,1,'C');
            $pdf .= Fpdf::SetFont('Arial','BI',12);
            $pdf .= Fpdf::Cell(0,7,utf8_decode('Fecha Inicial: '.$datos['dateIn'].' A '.$datos['dateOut']),0,1,'C');
            $pdf .= Fpdf::Ln();
            $departaments = $this->departamentRepository->getModel()->where('type','iglesia')->get();
            foreach($departaments AS $departament):
                $pdf .= Fpdf::SetFont('Arial','B',14);
                $pdf .= Fpdf::Cell(0,7,utf8_decode($departament->name),0,1,'C');
                $pdf .= Fpdf::Ln();
                $this->typeIncomesReport($departament->id,$datos);
                $pdf .= Fpdf::Ln();
                $this->typeExpesesReport($departament->id,$datos);
            endforeach;
            $pdf .= Fpdf::Ln();
        else:
            $pdf = Fpdf::Cell(0,7,utf8_decode('Informe movimientos x Departamento'),0,1,'C');
            $pdf .= Fpdf::SetFont('Arial','BI',12);
            $pdf .= Fpdf::Cell(0,7,utf8_decode('Fecha Inicial: '.$datos['dateIn'].' A '.$datos['dateOut']),0,1,'C');
            $pdf .= Fpdf::Ln();
            $departaments = $this->departamentRepository->getModel()->find($datos['departament']);
            $pdf .= Fpdf::SetFont('Arial','B',14);
            $pdf .= Fpdf::Cell(0,7,utf8_decode($departaments->name),0,1,'C');
            $pdf .= Fpdf::Ln();
            $this->typeIncomesReport($departaments->id,$datos);
            $pdf .= Fpdf::Ln();
            $this->typeExpesesReport($departaments->id,$datos);
        endif;

        Fpdf::Output('Informe x Departamentos.pdf','I');
        exit;
    }
    /**
     * ---------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
     * @Date Create: 2016-05-09
     * @Date Update: 2016-00-00
     * ---------------------------------------------------------------------
     * @Description: Generamos la seccion de ingresos del reporte de movimientos
     * de los departamentos
     *
     * @Pasos:
     *
     *
     *
     *
     *
     *
     * ----------------------------------------------------------------------
     * @return mixed
     * ----------------------------------------------------------------------
     */
    public function typeExpesesReport($id,$datos)
    {
        $pdf = Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Gastos'),1,1,'C');
        $pdf .= Fpdf::Ln();

        $typeExpenses = $this->typeExpenseRepository->getModel()->where('departament_id',$id)->get();
        $totalTypeEx = 0;
        foreach($typeExpenses AS $typeExpense):
            $expenses = $this->expensesRepository->getModel()->where('type_expense_id',$typeExpense->id)
                ->whereBetween('invoiceDate',[$datos['dateIn'],$datos['dateOut']])->get();
            $incomesSum = $this->expensesRepository->getModel()->where('type_expense_id',$typeExpense->id)
                ->whereBetween('invoiceDate',[$datos['dateIn'],$datos['dateOut']])->sum('amount');
            if(!$expenses->isEmpty()):
                $pdf .= Fpdf::SetX(15);
                $pdf .= Fpdf::Cell(30,7,utf8_decode('Fecha'),1,0,'C');
                $pdf .= Fpdf::Cell(40,7,utf8_decode('Informe'),1,0,'C');
                $pdf .= Fpdf::Cell(80,7,utf8_decode('Tipo Gasto'),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,utf8_decode('Monto'),1,1,'C');
                $totalExpenses =0;
                foreach($expenses AS $expense):
                    $pdf .= Fpdf::SetFont('Arial','',12);
                    $pdf .= Fpdf::SetX(15);
                    $pdf .= Fpdf::Cell(30,7,utf8_decode($expense->invoiceDate),1,0,'C');
                    $pdf .= Fpdf::Cell(40,7,utf8_decode($expense->invoiceNumber),1,0,'C');
                    $pdf .= Fpdf::Cell(80,7,utf8_decode($expense->typeExpenses->name),1,0,'C');
                    $pdf .= Fpdf::Cell(30,7,number_format($expense->amount,2),1,1,'C');
                    $totalExpenses += $expense->amount;
                endforeach;
                $pdf .= Fpdf::SetFont('Arial','B',14);
                $pdf .= Fpdf::SetX(15);
                $pdf .= Fpdf::Cell(150,7,utf8_decode('Total x Tipo de Gasto'),1,0,'R');
                $pdf .= Fpdf::Cell(30,7,number_format($totalExpenses,2),1,1,'C');
                $pdf .= Fpdf::Ln();
                $totalTypeEx += $totalExpenses;
            endif;

        endforeach;


        $transfers = $this->transfersRepository->getModel()->where('departament_id',$id)->where('type','salida')->get();
        $totalTransfer = 0;
        if(!$transfers->isEmpty()):
            $pdf = Fpdf::SetFont('Arial','B',12);
            $pdf .= Fpdf::Cell(0,7,utf8_decode('Transferencia'),1,1,'C');
            $pdf .= Fpdf::Ln();
            $pdf .= Fpdf::SetX(15);
            $pdf .= Fpdf::Cell(30,7,utf8_decode('Fecha'),1,0,'C');
            $pdf .= Fpdf::Cell(70,7,utf8_decode('Informe'),1,0,'C');
            $pdf .= Fpdf::Cell(50,7,utf8_decode('Tipo Gasto'),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,utf8_decode('Monto'),1,1,'C');

            foreach($transfers AS $transfer):
                $pdf .= Fpdf::SetFont('Arial','',12);
                $pdf .= Fpdf::SetX(15);
                $pdf .= Fpdf::Cell(30,7,utf8_decode($transfer->date),1,0,'C');
                $pdf .= Fpdf::Cell(70,7,utf8_decode(substr($transfer->detail,0,30)),1,0,'C');
                $pdf .= Fpdf::Cell(50,7,utf8_decode($transfer->departaments->name),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,number_format($transfer->amount,2),1,1,'C');
                $totalTransfer += $expense->amount;
            endforeach;
            $pdf .= Fpdf::SetFont('Arial','B',14);
            $pdf .= Fpdf::SetX(15);
            $pdf .= Fpdf::Cell(150,7,utf8_decode('Total x Transferencias'),1,0,'R');
            $pdf .= Fpdf::Cell(30,7,number_format($totalTransfer,2),1,1,'C');
            $pdf .= Fpdf::Ln();
        endif;
        $typeIncomes = $this->typeIncomeRepository->getModel()->where('departament_id',$id)->lists('id');
        $incomesSum = $this->incomeRepository->getModel()->whereIn('type_income_id',$typeIncomes)
            ->whereBetween('date',[$datos['dateIn'],$datos['dateOut']])->sum('balance');
        $transfersEnt = $this->transfersRepository->getModel()->where('departament_id',$id)->where('type','entrada')->sum('amount');
        $pdf .= Fpdf::SetFont('Arial','B',14);
        $pdf .= Fpdf::SetX(15);
        $pdf .= Fpdf::Cell(150,7,utf8_decode('Gasto Total del Departamento'),1,0,'R');
        $pdf .= Fpdf::Cell(30,7,number_format($totalTypeEx+$totalTransfer,2),1,1,'C');
        $pdf .= Fpdf::Ln();
        $pdf .= Fpdf::SetFont('Arial','B',14);
        $pdf .= Fpdf::SetX(15);
        $pdf .= Fpdf::Cell(150,7,utf8_decode('Saldo Disponible del Departamento'),1,0,'R');
        $pdf .= Fpdf::Cell(30,7,number_format(($incomesSum+$transfersEnt)-($totalTypeEx+$totalTransfer),2),1,1,'C');
        $pdf .= Fpdf::Ln();


    }
    /**
     * ---------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
     * @Date Create: 2016-05-09
     * @Date Update: 2016-00-00
     * ---------------------------------------------------------------------
     * @Description: Generamos la seccion de ingresos del reporte de movimientos
     * de los departamentos
     *
     * @Pasos:
     *
     *
     *
     *
     *
     *
     * ----------------------------------------------------------------------
     * @return mixed
     * ----------------------------------------------------------------------
     */
    public function typeIncomesReport($id,$datos)
    {
        $pdf = Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Ingresos'),1,1,'C');
        $pdf .= Fpdf::Ln();

        $typeIncomes = $this->typeIncomeRepository->getModel()->where('departament_id',$id)->get();
        $totalType = 0;
        foreach($typeIncomes AS $typeIncome):
            $incomes = $this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)
                ->whereBetween('date',[$datos['dateIn'],$datos['dateOut']])->get();

            if(!$incomes->isEmpty()):
                $pdf .= Fpdf::SetX(30);
                $pdf .= Fpdf::Cell(30,7,utf8_decode('Fecha'),1,0,'C');
                $pdf .= Fpdf::Cell(20,7,utf8_decode('Informe'),1,0,'C');
                $pdf .= Fpdf::Cell(40,7,utf8_decode('Tipo Ingreso'),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,utf8_decode('Monto'),1,1,'C');
                $totalIncome =0;
                foreach($incomes AS $income):
                    $incomesSum = $income->balance;
                    $pdf .= Fpdf::SetFont('Arial','',12);
                    $pdf .= Fpdf::SetX(30);
                    $pdf .= Fpdf::Cell(30,7,utf8_decode($income->date),1,0,'C');
                    $pdf .= Fpdf::Cell(20,7,utf8_decode($income->numberOf),1,0,'C');
                    $pdf .= Fpdf::Cell(40,7,utf8_decode($income->typeIncomes->name),1,0,'C');
                    if($typeIncome->part == 'SI'):
                        $pdf .= Fpdf::Cell(30,7,number_format(($incomesSum/5)*3,2),1,1,'C');
                        $totalIncome += ($incomesSum/5)*3;
                    else:
                        $pdf .= Fpdf::Cell(30,7,number_format($incomesSum,2),1,1,'C');
                        $totalIncome += $incomesSum;
                    endif;

                endforeach;
                $pdf .= Fpdf::SetFont('Arial','B',14);
                $pdf .= Fpdf::SetX(30);
                $pdf .= Fpdf::Cell(90,7,utf8_decode('Total x Tipo de Ingreso'),1,0,'R');
                $pdf .= Fpdf::Cell(30,7,number_format($totalIncome,2),1,1,'C');
                $pdf .= Fpdf::Ln();
                $totalType += $totalIncome;
            endif;
        endforeach;
        $transfers = $this->transfersRepository->getModel()->where('departament_id',$id)->where('type','entrada')->get();
        $totalTransfer = 0;

        if(!$transfers->isEmpty()):
            $pdf = Fpdf::SetFont('Arial','B',12);
            $pdf .= Fpdf::Cell(0,7,utf8_decode('Transferencia'),1,1,'C');
            $pdf .= Fpdf::Ln();
            $pdf .= Fpdf::SetX(15);
            $pdf .= Fpdf::Cell(30,7,utf8_decode('Fecha'),1,0,'C');
            $pdf .= Fpdf::Cell(70,7,utf8_decode('Informe'),1,0,'C');
            $pdf .= Fpdf::Cell(50,7,utf8_decode('Tipo Ingresos'),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,utf8_decode('Monto'),1,1,'C');

            foreach($transfers AS $transfer):
                $pdf .= Fpdf::SetFont('Arial','',12);
                $pdf .= Fpdf::SetX(15);
                $pdf .= Fpdf::Cell(30,7,utf8_decode($transfer->date),1,0,'C');
                $pdf .= Fpdf::Cell(70,7,utf8_decode(substr($transfer->detail,0,30)),1,0,'C');
                $pdf .= Fpdf::Cell(50,7,utf8_decode($transfer->departaments->name),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,number_format($transfer->amount,2),1,1,'C');
                $totalTransfer += $transfer->amount;
            endforeach;
            $pdf .= Fpdf::SetFont('Arial','B',14);
            $pdf .= Fpdf::SetX(15);
            $pdf .= Fpdf::Cell(150,7,utf8_decode('Total x Transferencias'),1,0,'R');
            $pdf .= Fpdf::Cell(30,7,number_format($totalTransfer,2),1,1,'C');
            $pdf .= Fpdf::Ln();
        endif;

        $pdf .= Fpdf::SetFont('Arial','B',14);
        $pdf .= Fpdf::SetX(30);
        $pdf .= Fpdf::Cell(90,7,utf8_decode('Ingresos Total del Departamento'),1,0,'R');
        $pdf .= Fpdf::Cell(30,7,number_format($totalType+$totalTransfer,2),1,1,'C');
        $pdf .= Fpdf::Ln();


    }
    /**
     * ---------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
     * @Date Create: 2016-05-09
     * @Date Update: 2016-00-00
     * ---------------------------------------------------------------------
     * @Description:Encabezado de reporte
     *
     *
     * @Pasos:
     *
     *
     *
     *
     *
     *
     * ----------------------------------------------------------------------
     * @return mixed
     * ----------------------------------------------------------------------
     */
    public function header()
    {
        $pdf  = Fpdf::AddPage('p','letter');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Apartado 10113-1000 San José, Costa Rica'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Teléfonos: 2224-8311 Fax:2225-0665'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        return $pdf;
    }

}
