<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/04/16
 * Time: 08:30 AM
 */

namespace SistemasAmigables\Http\Controllers\Report;


use Anouar\Fpdf\Facades\Fpdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\AccountRepository;
use SistemasAmigables\Repositories\BankRepository;
use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\RecordRepository;

class EstadoDeCuenta extends Controller
{

    /**
     * @var BankRepository
     */
    private $bankRepository;
    /**
     * @var CheckRepository
     */
    private $checkRepository;
    /**
     * @var AccountRepository
     */
    private $accountRepository;
    /**
     * @var RecordRepository
     */
    private $recordRepository;

    public function __construct(
        BankRepository $bankRepository,
        CheckRepository $checkRepository,
        AccountRepository $accountRepository,
        RecordRepository $recordRepository
    )
    {

        $this->bankRepository = $bankRepository;
        $this->checkRepository = $checkRepository;
        $this->accountRepository = $accountRepository;
        $this->recordRepository = $recordRepository;
    }



    public function index(){
        $this->header();
        $id = Input::get('id');
        $acount = $this->accountRepository->oneWhere('id',$id);
        $pdf = Fpdf::Cell(0,7,utf8_decode('Estado de Cuenta: '. Input::get('dateIn').' a '.Input::get('dateOut')),0,1,'C');
        $pdf .= Fpdf::Ln();
        $pdf .= Fpdf::SetFont('Arial','',12);
        $pdf .= Fpdf::Cell(100,7,utf8_decode($acount[0]->code),0,0,'L');
        $pdf .= Fpdf::Cell(80,7,utf8_decode($acount[0]->name),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','',12);
        $pdf .= Fpdf::Cell(25,7,utf8_decode('Fecha'),1,0,'C');
        $pdf .= Fpdf::Cell(25,7,utf8_decode('N° Deposito'),1,0,'C');
        $pdf .= Fpdf::Cell(50,7,utf8_decode('Sabado '),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Debito'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Credito'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode('Balance'),1,1,'C');
        $date = new Carbon(Input::get('dateIn'));
        $dateIn = $date->subMonth(1);
         $banksE = $this->bankRepository->getModel()->where('account_id',$id)->where('type','entradas')
            ->whereBetween('date',[$dateIn->format('Y-m-d'),$dateIn->endOfMonth()->format('Y-m-d')])->sum('balance');
        $banksS = $this->bankRepository->getModel()->where('account_id',$id)->where('type','salidas')
            ->whereBetween('date',[$dateIn->format('Y-m-d'),$dateIn->endOfMonth()->format('Y-m-d')])->sum('balance');
        $inicial = $banksE-$banksS;

        $pdf .= Fpdf::Cell(100,7,utf8_decode('Saldo Inicial: '),1,0,'L');
        if($inicial >= 0):
        $pdf .= Fpdf::Cell(30,7,utf8_decode($inicial),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,utf8_decode(0),1,0,'C');
        else:
            $pdf .= Fpdf::Cell(30,7,utf8_decode(0),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,utf8_decode($inicial),1,0,'C');

        endif;
        $pdf .= Fpdf::Cell(30,7,number_format($inicial,2),1,1,'C');
        $banks = $this->bankRepository->getModel()->where('account_id',$id)->whereBetween('date',[Input::get('dateIn'),Input::get('dateOut')])->orderBy('date','ASC')->get();
        $balanceBank = 0;
        foreach($banks AS $bank):

            $pdf .= Fpdf::Cell(25,7,utf8_decode($bank->date),1,0,'L');
            $pdf .= Fpdf::Cell(25,7,utf8_decode($bank->number),1,0,'L');
            if($bank->records):
            $pdf .= Fpdf::Cell(50,7,utf8_decode($bank->records->saturday),1,0,'L');
            else:
            $pdf .= Fpdf::Cell(50,7,utf8_decode(''),1,0,'L');
                    endif;
            if($bank->type=='entradas'):
                $pdf .= Fpdf::Cell(30,7,number_format($bank->balance,2),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,number_format(0,2),1,0,'C');
                $balanceBank += $bank->balance;
            elseif($bank->type=='salidas'):
                $pdf .= Fpdf::Cell(30,7,number_format(0,2),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,number_format($bank->balance,2),1,0,'C');
                $balanceBank -= $bank->balance;
            endif;


            $pdf .= Fpdf::Cell(30,7,number_format($balanceBank,2),1,1,'C');
        endforeach;

        $checks = $this->checkRepository->getModel()->where('account_id',$id)->whereBetween('date',[Input::get('dateIn'),Input::get('dateOut')])->orderBy('date','ASC')->get();
        $balance = $balanceBank;
        $totalC =0;
        foreach($checks AS $check):
            $pdf .= Fpdf::Cell(25,7,utf8_decode($check->date),1,0,'L');
            $pdf .= Fpdf::Cell(25,7,utf8_decode($check->number),1,0,'L');
            $pdf .= Fpdf::Cell(50,7,substr(utf8_decode($check->name),0,20),1,0,'L');
            $pdf .= Fpdf::Cell(30,7,number_format(0),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,number_format($check->balance,2),1,0,'C');
            $totalC += $check->balance;
                $balance -=  $check->balance;

            $pdf .= Fpdf::Cell(30,7,number_format($balance,2),1,1,'C');
        endforeach;
        $pdf .= Fpdf::Cell(100,7,substr(utf8_decode('Total'),0,20),1,0,'R');
        $pdf .= Fpdf::Cell(30,7,number_format($balanceBank),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($totalC,2),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($balance,2),1,1,'C');
        Fpdf::Output('Estado-de-Cuenta.pdf','I');
        exit;
    }

    public function depositos($year){
        $this->header();
        $pdf = Fpdf::Cell(0,7,utf8_decode('Informes de Sabados y Sus Depositos'),0,1,'C');
        $pdf .= Fpdf::Ln();
        $pdf .= Fpdf::SetFont('Arial','B',14);
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Año '.$year),0,1,'C');
        $pdf .= Fpdf::SetFont('Arial','',12);

        $banks = $this->bankRepository->getModel()->whereBetween('date',[($year-1).'-12-27',($year).'-12-25'])->orderBy('date','ASC')->get();
        foreach($banks AS $bank):
            $pdf .= Fpdf::Cell(25,7,utf8_decode('fecha'),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,utf8_decode('N° Deposito'),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,utf8_decode('Cantidad '),1,1,'C');

            $pdf .= Fpdf::Cell(25,7,utf8_decode($bank->date),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,utf8_decode($bank->number),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,number_format($bank->balance,2),1,1,'C');
        $records = $this->recordRepository->getModel()->where('id',$bank->record_id)->orderBy('saturday','ASC')->get();

            $pdf .= Fpdf::SetX(15);
            $pdf .= Fpdf::Cell(25,7,utf8_decode('Sabado'),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,utf8_decode('N° Control Interno'),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,utf8_decode('N° Miembros'),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,utf8_decode('Cantidad '),1,1,'C');
        foreach($records AS $record):
            $pdf .= Fpdf::SetX(15);
            $pdf .= Fpdf::Cell(25,7,utf8_decode($record->saturday),1,0,'L');
            $pdf .= Fpdf::Cell(40,7,utf8_decode($record->controlNumber),1,0,'C');
            $pdf .= Fpdf::Cell(30,7,utf8_decode($record->rows),1,0,'C');
            $pdf .= Fpdf::Cell(40,7,number_format($record->balance,2),1,1,'C');
            $pdf .= Fpdf::Ln();

        endforeach;
        endforeach;

        Fpdf::Output('Estado-de-Cuenta.pdf','I');
        exit;
    }

    public function header()
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
        return $pdf;
    }
}