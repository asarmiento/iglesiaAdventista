<?php namespace SistemasAmigables\Http\Controllers;

use Anouar\Fpdf\Facades\Fpdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Repositories\BalanceChurchRepository;
use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\PeriodRepository;
use SistemasAmigables\Repositories\RecordRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;

class ChurchController extends Controller {

    /**
     * @var RecordRepository
     */
    private $recordRepository;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var PeriodRepository
     */
    private $periodRepository;
    /**
     * @var TypeIncomeRepository
     */
    private $typeIncomeRepository;
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;
    /**
     * @var BalanceChurchRepository
     */
    private $balanceChurchRepository;
    /**
     * @var ExpensesRepository
     */
    private $expensesRepository;
    /**
     * @var CheckRepository
     */
    private $checkRepository;

    public function __construct(
        RecordRepository $recordRepository,
        IncomeRepository $incomeRepository,
        PeriodRepository $periodRepository,
        TypeIncomeRepository $typeIncomeRepository,
        DepartamentRepository $departamentRepository,
        BalanceChurchRepository $balanceChurchRepository,
        ExpensesRepository $expensesRepository,
        CheckRepository $checkRepository
    )
    {

        $this->recordRepository = $recordRepository;
        $this->incomeRepository = $incomeRepository;
        $this->periodRepository = $periodRepository;
        $this->typeIncomeRepository = $typeIncomeRepository;
        $this->departamentRepository = $departamentRepository;
        $this->balanceChurchRepository = $balanceChurchRepository;
        $this->expensesRepository = $expensesRepository;
        $this->checkRepository = $checkRepository;
    }
    /**
     * Display a listing of iglesias
     *
     * @return Response
     */
    public function index() {
        $iglesias = Iglesia::withTrashed()->get();

        return View::make('iglesias.index', compact('iglesias'));
    }


    /**
     * Store a newly created iglesia in storage.
     *
     * @return Response
     */
    public function store() {
        $json = Input::get('data');
        $data = json_decode($json);

        $iglesia = new Iglesia;

        if ($iglesia->isValid((array) $data)):
            $iglesia->phone = $data->phone;
            $iglesia->address = Str::upper($data->address);
            $iglesia->name = Str::upper($data->name);
            $iglesia->save();
            return 1;
        endif;

        if (Request::ajax()):
            return Response::json([
                        'success' => false,
                        'errors' => $iglesia->errors
            ]);
        else:
            return Redirect::back()->withErrors($iglesia->errors)->withInput();
        endif;
    }



    /**
     * Update the specified iglesia in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update() {
        //capturamos los datos enviados
        $json = Input::get('data');       
        $data = json_decode($json);
        
        //hacemos el cambio de estado de acuerdo a lo solicitado
        if ($data->state == 1):
            Iglesia::withTrashed()->find($data->id)->restore();
        else:
            Iglesia::destroy($data->id);
        endif;
        //enviamos a buscar los datos a editar
        $Iglesia = Iglesia::withTrashed()->find($data->id);
        // si no existe enviamos un mensaje de error via json
        if (is_null($Iglesia)):
            return View::make('iglesia.index', json_encode(array('message' => 'La Iglesia no existe')));
        endif;
        
        //validamos los datos
        if ($Iglesia->isValid((array) $data)):
            //si estan correctos los editamos
            $Iglesia->phone = $data->phone;
            $Iglesia->address = Str::upper($data->address);
            $Iglesia->name = Str::upper($data->name);
            $Iglesia->save();
            return 1;
        endif;
        //si estan incorrecto enviamos mensaje via ajax 
        if (Request::ajax()):
            return Response::json([
                        'success' => false,
                        'errors' => $Iglesia->errors
            ]);
        else:
            return Redirect::back()->withErrors($Iglesia->errors)->withInput();
        endif;
    }

    /**
     * Remove the specified iglesia from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $data = Iglesia::destroy($id);
        if ($data):
            return 1;
        endif;

        return json_encode(array('message' => 'Ya esta Inactivo'));
    }

    /**
     * Restore the specified typeuser from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function restore($id) {

        $data = Iglesia::onlyTrashed()->find($id);

        if ($data):
            $data->restore();
            return 1;
        endif;

        return json_encode(array('message' => 'Ya esta activa'));
    }

    /**
     * ---------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
     * @Date Create: 2016-05-26
     * @Date Update: 2016-00-00
     * ---------------------------------------------------------------------
     * @Description:
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
    public function auditoria()
    {
        $periods = $this->periodRepository->getModel()->get();
        return view('iglesias.auditoria',compact('periods'));
    }

    /**
     * ---------------------------------------------------------------------
     * @Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
     * @Date Create: 2016-05-26
     * @Date Update: 2016-00-00
     * ---------------------------------------------------------------------
     * @Description:
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
    public function pdfAuditoria()
    {
        $year = Input::get('year');
        $pdf  = Fpdf::AddPage('L','letter');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('INFORME PARA AUDITORIA'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','i',10);
        $pdf .= Fpdf::Cell(0,5,utf8_decode('Apartado 10113-1000 San José, Costa Rica'),0,1,'C');
        $pdf .= Fpdf::Cell(0,5,utf8_decode('Teléfonos: 2224-8311 Fax:2225-0665'),0,1,'C');
        $pdf .= Fpdf::Cell(0,5,utf8_decode('acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('AÑO '.$year),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('IGLESIA DE QUEPOS'),0,1,'C');

        $pdf .= Fpdf::SetFont('Arial','B',10);

        $pdf .= Fpdf::Cell(20,7,utf8_decode('Fecha'),1,0,'C');
        $pdf .= Fpdf::Cell(25,7,utf8_decode('Cont. Interno'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Ing. Generales'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Fon.ACSCR'),1,0,'C');
        $pdf .= Fpdf::Cell(40,7,utf8_decode('60% Of. Loc. y Otros'),1,0,'C');
        $pdf .= Fpdf::Cell(25,7,utf8_decode('Fondo Const.'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Gastos'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Pru. de Saldo'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Saldo'),1,1,'C');
        $periods = $this->periodRepository->getModel()->where('year',$year)->get();
        $periodsSaldoIni = $this->balanceChurchRepository->getModel()->whereHas('periods',function($q){
            $q->where('year',Input::get('year')-1);
        })->get()->last();
        $pdf .= Fpdf::Cell(105,7,utf8_decode('Saldo Inicial '.(Input::get('year')-1)),1,0,'C');
        $pdf .= Fpdf::Cell(40,7,number_format($periodsSaldoIni->amount,2),1,0,'C');
        $pdf .= Fpdf::Cell(25,7,utf8_decode(''),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode(''),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode(''),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode(''),1,1,'C');
        $totalM =0;
        $totalA =0;
        $totalC =0;
        $totalP =0;
        $totalS =0;
        $totalgasto =0;
        foreach($periods AS $period):
            $informes = $this->recordRepository->getModel()->where('period_id',$period->id)->orderBy('saturday','ASC')->get();
            $totalMes = 0;
            $totalAsc = 0;
            $totalCamp = 0;
            $totalPrueba = 0;
            $pdf .= Fpdf::SetFont('Arial','I',12);
            $pdf .= Fpdf::Cell(20,7,utf8_decode($period->month.'-'.$period->year),1,0,'C');
            foreach($informes AS $informe):
                $campo = $this->incomeRepository->getModel()->amountCampo($informe->id);
                $iglesia = $informe->balance-$campo;
                $totalMes += $informe->balance;
                $totalAsc += $campo;
                $totalCamp += $iglesia;
                $totalPrueba += ($campo+$iglesia);
            endforeach;
            $date = new Carbon($period->year.'-'.$period->month.'-01');
            $dateIn = $date->format('Y-m-d');
            $dateP = $date;
            if( $date->format('Y-m-d') == '2015-01-01'):
                $dateIn = '2014-12-20';
            endif;
            $dateOut = $dateP->endOfMonth()->format('Y-m-d');
            $gasto  = $this->expensesRepository->getModel()->whereHas('typeExpenses',function($q){
                $q->where('type','iglesia');
            })->whereBetween('invoiceDate',[$dateIn,$dateOut])->sum('amount');



            $pdf .= Fpdf::Cell(25,7,utf8_decode(''),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,number_format($totalMes,2),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,number_format($totalAsc,2),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,number_format($totalCamp,2),1,0,'C');
            $pdf .= Fpdf::Cell(25,7,utf8_decode(''),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,number_format($gasto,2),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,number_format($totalPrueba,2),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,number_format($totalCamp-$gasto,2),1,1,'C');
            $totalM += $totalMes;
            $totalA += $totalAsc;
            $totalC += $totalCamp;
            $totalS += $totalCamp-$gasto;
            $totalP += $totalAsc+$totalCamp;
            $totalgasto += $gasto;
        endforeach;
        $pdf .= Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Cell(20,7,utf8_decode(''),1,0,'C');
        $pdf .= Fpdf::Cell(25,7,utf8_decode(''),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($totalM,2),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($totalA,2),1,0,'C');
        $pdf .= Fpdf::Cell(40,7,number_format($totalC+$periodsSaldoIni->amount,2),1,0,'C');
        $pdf .= Fpdf::Cell(25,7,utf8_decode(''),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($totalgasto,2),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($totalP,2),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($totalS+$periodsSaldoIni->amount,2),1,1,'C');
        $pdf .= Fpdf::Ln(50);
        $this->detalleAuditoria($year);

        Fpdf::Output('Informe-Mendual.pdf','I');
        exit;
    }

    public function detalleAuditoria($year)
    {
        $periods = $this->periodRepository->getModel()->where('year',$year)->get();
        foreach($periods AS $period):
            $informes = $this->recordRepository->getModel()->where('period_id',$period->id)->orderBy('saturday','ASC')->get();
            $totalMes = 0;
            $totalAsc = 0;
            $totalCamp = 0;
            $totalPrueba = 0;
            $pdf = Fpdf::SetFont('Arial','B',12);
            $pdf .= Fpdf::Cell(265,7,utf8_decode($period->month.'-'.$period->year),1,1,'C');
            $pdf .= Fpdf::SetFont('Arial','B',10);

            $pdf .= Fpdf::Cell(20,7,utf8_decode('Fecha'),1,0,'C');
            $pdf .= Fpdf::Cell(25,7,utf8_decode('Cont. Interno'),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,utf8_decode('Ing. Generales'),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,utf8_decode('Fon.ACSCR'),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,utf8_decode('60% Of. Loc. y Otros'),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,utf8_decode('Fondo Const.'),1,0,'C');
            $pdf .= Fpdf::Cell(25,7,utf8_decode('Gastos'),1,0,'C');
            $pdf .= Fpdf::Cell(25,7,utf8_decode('Pru. de Saldo'),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,utf8_decode('Saldo'),1,1,'C');
            foreach($informes AS $informe):
                $campo = $this->incomeRepository->getModel()->amountCampo($informe->id);
                $iglesia = $informe->balance-$campo;
                $pdf .= Fpdf::Cell(20,7,utf8_decode($informe->saturday),1,0,'C');
                $pdf .= Fpdf::Cell(25,7,utf8_decode($informe->controlNumber),1,0,'C');
                $pdf .= Fpdf::Cell(40,7,number_format($informe->balance,2),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,number_format($campo,2),1,0,'C');
                $pdf .= Fpdf::Cell(40,7,number_format($iglesia,2),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,utf8_decode(''),1,0,'C');
                $pdf .= Fpdf::Cell(25,7,utf8_decode(''),1,0,'C');
                $pdf .= Fpdf::Cell(25,7,number_format(($campo+$iglesia),2),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,number_format($iglesia,2),1,1,'C');
                $totalMes += $informe->balance;
                $totalAsc += $campo;
                $totalCamp += $iglesia;
                $totalPrueba += ($campo+$iglesia);

            endforeach;
            $pdf .= Fpdf::Cell(20,7,utf8_decode('Totales'),1,0,'C');
            $pdf .= Fpdf::Cell(25,7,utf8_decode(''),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,number_format($totalMes,2),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,number_format($totalAsc,2),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,number_format($totalCamp,2),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,utf8_decode(''),1,0,'C');
            $pdf .= Fpdf::Cell(25,7,utf8_decode(''),1,0,'C');
            $pdf .= Fpdf::Cell(25,7,number_format($totalPrueba,2),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,number_format($totalCamp,2),1,1,'C');
            $pdf .= Fpdf::Ln();
        endforeach;
    }
    public function report($token)
    {

        $depart = $this->departamentRepository->getModel()->where('type','iglesia')->orderBy('id','DESC')->count();
        $period = $this->periodRepository->token($token);
        $this->header();

        $pdf = Fpdf::SetFont('Arial','B',12);
        $pdf .= Fpdf::Cell(200,7,utf8_decode('Nombre del Tesorero: Anwar Sarmiento Ramos'),1,0,'L');
        $pdf .= Fpdf::Cell(60,7,utf8_decode('Iglesia de: QUEPOS'),1,1,'L');
        $pdf .= Fpdf::Cell(150,7,utf8_decode(''),1,0,'L');
        $pdf .= Fpdf::Cell(110,7,utf8_decode('Para mes de: '.$period->month.'-'.$period->year),1,1,'L');

        $pdf .= Fpdf::Ln();
        $pdf .= Fpdf::SetFont('Arial','B',10);
        $pdf .= Fpdf::Cell(74,7,utf8_decode(''),1,0,'C');
        $pdf .= Fpdf::Cell(154,7,utf8_decode('FONDOS PARA ENVIAR A LA ASOCIACIÓN'),1,1,'C');
       // $pdf .= Fpdf::Cell(($depart*25),7,utf8_decode('FONDOS PARA EL PRESUPUESTO LOCAL'),1,1,'C');

        $pdf = Fpdf::SetFont('Arial','B',10);
        $pdf .= Fpdf::Cell(20,15,utf8_decode('Fecha'),1,0,'C');
        $y = Fpdf::GetY();
        $pdf .= Fpdf::MultiCell(17,5,utf8_decode('N° Control Semanal'),1,'C');
        $pdf .= Fpdf::SetXY(47,$y);
        $pdf .= Fpdf::Cell(15,15,utf8_decode('Hoja N°'),1,0,'L');
        $pdf .= Fpdf::MultiCell(22,7.5,utf8_decode('Total Recibido'),1,'C');
        $pdf .= Fpdf::SetXY(84,$y);
        $pdf .= Fpdf::MultiCell(22,7.5,utf8_decode('Total Asociacion'),1,'C');
        $pdf .= Fpdf::SetXY(106,$y);
        $pdf .= Fpdf::Cell(20,15,utf8_decode('Diezmos'),1,0,'C');
        $pdf .= Fpdf::MultiCell(20,7.5,utf8_decode('20% Mundial'),1,'C');
        $pdf .= Fpdf::SetXY(146,$y);
        $pdf .= Fpdf::MultiCell(20,7.5,utf8_decode('20% Desarr'),1,'C');
        $pdf .= Fpdf::SetXY(166,$y);
        $typeIncomes = $this->typeIncomeRepository->ofrendaAsoc();
        foreach($typeIncomes As $typeIncome):
        $pdf .= Fpdf::Cell(21,15,utf8_decode($typeIncome->name),1,'C');
        endforeach;

        $pdf .= Fpdf::Cell(30,15,utf8_decode('Fondo Local'),1,0,'C');
        $i = 0;
      /*  $departaments = $this->departamentRepository->getModel()->where('type','iglesia')->orderBy('id','DESC')->get();
        foreach($departaments As $departament): $i++;
            $pdf = Fpdf::SetFont('Arial','B',10);
            $pdf .= Fpdf::Cell(25,15,utf8_decode(substr($departament->name,0,12)),1,0,'C');
        endforeach;*/

        /********************************************************************************/
        $departaments = $this->departamentRepository->getModel()->where('type','iglesia')->orderBy('id','DESC')->get();
        $date = new Carbon($period->year.'-'.$period->month.'-01');
        $dateIn = $date->format('Y-m-d');
        $dateP = $date;

        $dateOut = $dateP->subMonth(1)->endOfMonth()->format('Y-m-d');

        $saldo = $this->balanceChurchRepository->oneWhere('date',$dateOut);

        $pdf = Fpdf::Ln();
        $pdf = Fpdf::SetFont('Arial','B',10);
        $pdf .= Fpdf::Cell(198,15,utf8_decode('VIENE'),1,0,'R');
        $pdf .= Fpdf::Cell(30,15,number_format($saldo[0]->amount,2),1,1,'C');
       /* $balanceLocal = $this->balanceChurchRepository->oneWhereSum('period_id',$period->id,'amount');
        $balanceLocal = $balanceLocal -($departaments[0]->budget*$depart-$departaments[0]->budget );
        $pdf .= Fpdf::Cell(25,15,number_format($balanceLocal,2),1,0,'C');
        $count = $depart ;
        $i=0;
        foreach($departaments As $departament): $i++;
            $pdf = Fpdf::SetFont('Arial','B',10);
            if($i == 1):

            elseif($i <= ($count)):
                $pdf .= Fpdf::Cell(25,15,utf8_decode(substr($departament->budget,0,12)),1,0,'C');
            endif;
        endforeach;
        $pdf .= Fpdf::Ln();
        $records = $this->recordRepository->oneWhere('period_id',$period->id);

*/
        $date = new Carbon($period->year.'-'.$period->month.'-01');
        $dateIn = $date->format('Y-m-d');
        $dateP = $date;
        if( $date->format('Y-m-d') == '2015-01-01'):
            $dateIn = '2014-12-20';
        endif;
        $dateOut = $dateP->endOfMonth()->format('Y-m-d');
        $records = $this->recordRepository->getModel()->where('period_id',$period->id)->orderBy('saturday','ASC')->get();
        $totalFondoLocal=0;
        foreach($records AS $record):
            $pdf = Fpdf::SetFont('Arial','B',10);
            $pdf .= Fpdf::Cell(20,7,utf8_decode($record->saturday),1,0,'C');
            $y = Fpdf::GetY();
            $pdf .= Fpdf::Cell(17,7,utf8_decode($record->controlNumber),1,0,'C');
            $pdf .= Fpdf::Cell(15,7,utf8_decode(''),1,0,'L');
            $pdf .= Fpdf::Cell(22,7,number_format($record->balance),1,0,'C');
            $pdf .= Fpdf::Cell(22,7,number_format($this->incomeRepository->campoRecord($record->id,$dateIn,$dateOut),2),1,0,'C');
            $pdf .= Fpdf::SetXY(106,$y);
            $pdf .= Fpdf::Cell(20,7,number_format($this->incomeRepository->diezmosRecord($record->id,$dateIn,$dateOut),2),1,0,'C');
            $pdf .= Fpdf::Cell(20,7,number_format($this->incomeRepository->ofrendaRecord($record->id,$dateIn,$dateOut),2),1,0,'C');
            $pdf .= Fpdf::Cell(20,7,number_format($this->incomeRepository->ofrendaRecord($record->id,$dateIn,$dateOut),2),1,0,'C');
            $typeIncomes = $this->typeIncomeRepository->ofrendaAsoc();
            foreach($typeIncomes As $typeIncome):
                $pdf .= Fpdf::Cell(21,7,number_format($this->incomeRepository->ofrendaRecord($typeIncome->id,$dateIn,$dateOut),2),1,0,'C');
            endforeach;
            $pdf .= Fpdf::Cell(30,7,number_format($record->balance-$this->incomeRepository->campoRecord($record->id,$dateIn,$dateOut),2),1,1,'C');
            $totalFondoLocal += $record->balance-$this->incomeRepository->campoRecord($record->id,$dateIn,$dateOut);
            /*foreach($departaments As $departament): $i++;
                $pdf = Fpdf::SetFont('Arial','B',10);
                $typeIncome = $this->typeIncomeRepository->getModel()->where('departament_id',$departament->id)->lists('id');
                $balance = $this->incomeRepository->getModel()->whereIn('type_income_id',$typeIncome)->where('record_id',$record->id)->sum('balance');
                $pdf .= Fpdf::Cell(25,15,number_format($balance,2),1,0,'C');
            endforeach;*/
        endforeach;
        $pdf .= Fpdf::Cell(198,7,utf8_decode('Total de Ingresos:'),1,0,'R');
        $pdf .= Fpdf::Cell(30,7,number_format($saldo[0]->amount+$totalFondoLocal,2),1,1,'C');
        $gastos  = $this->expensesRepository->getModel()->whereHas('typeExpenses',function($q){
            $q->where('type','iglesia');
        })->whereBetween('invoiceDate',[$dateIn,$dateOut])->sum('amount');
        $pdf .= Fpdf::Cell(198,7,utf8_decode('Total de Gastos:'),1,0,'R');
        $pdf .= Fpdf::Cell(30,7,number_format($gastos,2),1,1,'C');
        $pdf .= Fpdf::Cell(198,7,utf8_decode('Saldo:'),1,0,'R');
        $pdf .= Fpdf::Cell(30,7,number_format(($saldo[0]->amount+$totalFondoLocal)-$gastos,2),1,1,'C');



        Fpdf::Output('Informe-Mendual.pdf','I');
        exit;
    }

    public function header()
    {
        $pdf  = Fpdf::AddPage('L','letter');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día'),0,1,'C');
        $pdf .= Fpdf::Cell(0,7,utf8_decode('CONTROL MENSUAL DE DIEZMOS Y OFRENDAS'),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','i',10);
        $pdf .= Fpdf::Cell(0,5,utf8_decode('Apartado 10113-1000 San José, Costa Rica'),0,1,'C');
        $pdf .= Fpdf::Cell(0,5,utf8_decode('Teléfonos: 2224-8311 Fax:2225-0665'),0,1,'C');
        $pdf .= Fpdf::Cell(0,5,utf8_decode('acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com'),0,1,'C');
         return $pdf;
    }
}
