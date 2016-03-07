<?php

namespace SistemasAmigables\Http\Controllers\Report;


use Anouar\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\CampoRepository;
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

    public function __construct(
        RecordRepository $recordRepository,
        CampoRepository $campoRepository,
        IncomeRepository $incomeRepository
    )
    {

        $this->recordRepository = $recordRepository;
        $this->campoRepository = $campoRepository;
        $this->incomeRepository = $incomeRepository;
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
            endif;
        endforeach;

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