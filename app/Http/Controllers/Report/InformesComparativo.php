<?php

namespace SistemasAmigables\Http\Controllers\Report;


use Anouar\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\CampoRepository;
use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\RecordRepository;

/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 06/03/16
 * Time: 09:12 PM
 */
class InformesComparativo extends Controller
{


    /**
     * @var RecordRepository
     */
    private $recordRepository;
    /**
     * @var CampoRepository
     */
    private $campoRepository;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var CheckRepository
     */
    private $checkRepository;

    public function __construct(
        RecordRepository $recordRepository,
        CampoRepository $campoRepository,
        IncomeRepository $incomeRepository,
        CheckRepository $checkRepository
    )
    {

        $this->recordRepository = $recordRepository;
        $this->campoRepository = $campoRepository;
        $this->incomeRepository = $incomeRepository;
        $this->checkRepository = $checkRepository;
    }


    public function index(){
        return view('banks.pageCampo');
    }


    public function report()
    {
        $date = Input::all();
        $this->header();
        $pdf  = Fpdf::ln();
        $records = $this->recordRepository->getModel()->whereBetween('saturday',[$date['dateIn'],$date['dateOut']])->orderBy('saturday','ASC')->get();
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(30,7,'Fecha',1,0,'C');
        $pdf .= Fpdf::Cell(35,7,'Monto',1,0,'C');
        $pdf .= Fpdf::Cell(40,7,utf8_decode('N° Deposito'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Deposito',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Monto',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Diferencia',1,1,'C');
        $total = 0;
        foreach($records AS $record):
            $pdf .= Fpdf::SetFont('Arial','',12);
            $campo = $this->campoRepository->getModel()->where('record_id',$record->id)->get();
            $income = $this->incomeRepository->amountCampo($record->id);
            if($campo->isEmpty()):

            else:
                $pdf .= Fpdf::Cell(30,7,$record->saturday,1,0,'C');
                $pdf .= Fpdf::Cell(35,7,number_format($income,2),1,0,'C');
                $pdf .= Fpdf::Cell(40,7,$campo[0]->number,1,0,'C');
                $pdf .= Fpdf::Cell(30,7,$campo[0]->date,1,0,'C');
                $pdf .= Fpdf::Cell(30,7,number_format($campo[0]->amount,2),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,number_format($income-$campo[0]->amount),1,1,'C');
                $total += $income-$campo[0]->amount;
            endif;
        endforeach;
        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(35,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(40,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Total: ',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($total),1,1,'C');
        $pdf .= Fpdf::ln();
        $pdf .= Fpdf::Cell(0,7,'Informes no Reportados con depositos',1,1,'C');
        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(30,7,'Fecha',1,0,'C');
        $pdf .= Fpdf::Cell(35,7,'Monto',1,0,'C');
        $pdf .= Fpdf::Cell(40,7,utf8_decode('N° Deposito'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Deposito',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Monto',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Diferencia',1,1,'C');
        $totalIn = 0;
        foreach($records AS $record):
            $pdf .= Fpdf::SetFont('Arial','',12);
            $campo = $this->campoRepository->getModel()->where('record_id',$record->id)->get();
            $income = $this->incomeRepository->amountCampo($record->id);
            if($campo->isEmpty()):
                $pdf .= Fpdf::Cell(30,7,$record->saturday,1,0,'C');
                $pdf .= Fpdf::Cell(35,7,number_format($income,2),1,0,'C');
                $pdf .= Fpdf::Cell(40,7,'',1,0,'C');
                $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
                $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
                $pdf .= Fpdf::Cell(30,7,'',1,1,'C');
                $totalIn += $income;
            endif;
        endforeach;


        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(35,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(40,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Total: ',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($totalIn),1,1,'C');
        $pdf .= Fpdf::ln();


        $pdf .= Fpdf::Cell(0,7,'Cheques Reportados con Diferencias',1,1,'C');

        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(30,7,'Fecha',1,0,'C');
        $pdf .= Fpdf::Cell(35,7,'Monto',1,0,'C');
        $pdf .= Fpdf::Cell(40,7,utf8_decode('N° Deposito'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Deposito',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Monto',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Diferencia',1,1,'C');

        $checks = $this->checkRepository->getModel()->where('type','campo')->orderBy('date','ASC')->get();
        $chequesDif =0;
        foreach($checks AS $check):
            $pdf .= Fpdf::SetFont('Arial','',12);
            $suma = $this->campoRepository->getModel()->where('check_id',$check->id)->sum('amount');

            if($suma > 0):

            else:
                $pdf .= Fpdf::Cell(30,7,$check->date,1,0,'C');
                $pdf .= Fpdf::Cell(35,7,$check->number,1,0,'C');
                $pdf .= Fpdf::Cell(40,7,number_format($check->balance-$suma,2),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
                $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
                $pdf .= Fpdf::Cell(30,7,'',1,1,'C');
                $chequesDif += $check->balance-$suma;
            endif;
        endforeach;
        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(35,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(40,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Total: ',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($chequesDif),1,1,'C');
        $pdf .= Fpdf::ln();

        /***/
        $pdf .= Fpdf::Cell(0,7,'Cheques no Reportados con depositos',1,1,'C');

        $pdf .= Fpdf::SetFont('Arial','B',16);
        $pdf .= Fpdf::Cell(30,7,'Fecha',1,0,'C');
        $pdf .= Fpdf::Cell(35,7,'Monto',1,0,'C');
        $pdf .= Fpdf::Cell(40,7,utf8_decode('N° Deposito'),1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Deposito',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Monto',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Diferencia',1,1,'C');

        $checks = $this->checkRepository->getModel()->where('type','campo')->orderBy('date','ASC')->get();
        $cheques =0;
        foreach($checks AS $check):
            $pdf .= Fpdf::SetFont('Arial','',12);
            $campo = $this->campoRepository->getModel()->where('check_id',$check->id)->get();

            if($campo->isEmpty()):
                $pdf .= Fpdf::Cell(30,7,$check->date,1,0,'C');
                $pdf .= Fpdf::Cell(35,7,$check->number,1,0,'C');
                $pdf .= Fpdf::Cell(40,7,number_format($check->balance,2),1,0,'C');
                $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
                $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
                $pdf .= Fpdf::Cell(30,7,'',1,1,'C');
                $cheques += $check->balance;
            endif;
        endforeach;
        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(35,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(40,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Total: ',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format($cheques),1,1,'C');
        $pdf .= Fpdf::ln();

        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(35,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(40,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,'Total: ',1,0,'C');
        $pdf .= Fpdf::Cell(30,7,number_format(($total+$totalIn)-($cheques+$chequesDif)),1,1,'C');
        $pdf .= Fpdf::ln();

        $pdf  .= Fpdf::ln();
        $y = Fpdf::GetY();
        Fpdf::Output('Informe-Semana: '.$date['dateIn'].' a '.$date['dateOut'].'.pdf','I');
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
        $pdf .= Fpdf::Cell(0,7,utf8_decode('Informes Comparativo de Informes y Depositos a la Asociación'),0,1,'C');
        return $pdf;
    }
}