<?php

namespace SistemasAmigables\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use SistemasAmigables\Http\Requests;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\BalanceChurchRepository;
use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\PeriodRepository;
use SistemasAmigables\Repositories\RecordRepository;

class PeriodsController extends Controller
{
    /**
     * @var PeriodRepository
     */
    private $periodRepository;
    /**
     * @var CheckRepository
     */
    private $checkRepository;
    /**
     * @var RecordRepository
     */
    private $recordRepository;
    /**
     * @var BalanceChurchRepository
     */
    private $balanceChurchRepository;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;

    public function __construct(
        PeriodRepository $periodRepository,
        CheckRepository $checkRepository,
        RecordRepository $recordRepository,
        BalanceChurchRepository $balanceChurchRepository,
        IncomeRepository $incomeRepository

    )
    {

        $this->periodRepository = $periodRepository;
        $this->checkRepository = $checkRepository;
        $this->recordRepository = $recordRepository;
        $this->balanceChurchRepository = $balanceChurchRepository;
        $this->incomeRepository = $incomeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = $this->periodRepository->allData();
        return view('periods.index',compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $period = $this->periodRepository->getModel()->orderBy('year','DESC')->orderBy('month','DESC')->first();

        $day = 26;
        $date = new Carbon($day.'-'.$period->month.'-'.$period->year);
        $date = $date->addMonth(1);

        $periods = ['old'=>$period->month.'-'.$period->year,'new'=>($date->format('m')).'-'.$date->format('Y')];

        return view('periods.create',compact('periods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = Input::all();
        $dateOld = explode("-",$datos['oldPeriod']);
        Session::put('dateOld',$dateOld);
        $spli = explode("-",$datos['newPeriod']);
        $data = [
            'dateIn'=>$datos['dateIn'],
            'dateOut'=>$datos['dateOut'],
            'month'=>$spli[0],
            'year'=>$spli[1],
            'church_id'=>1,
            'token'=>md5($datos['oldPeriod'])];

        $period = $this->periodRepository->getModel();
        if($period->isValid($data)):
            $period->fill($data);
            $period->save();
            $this->updateFinishBalance($period->id);
            $this->updatePeriod($spli,$period->id);
            return redirect('/iglesia/cambiar/periodo');
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFinishBalance($period)
    {
        $dateOld = Session::get('dateOld');
        $periodOld = $this->periodRepository->getModel()->where('month',$dateOld[0])->where('church_id',1)
            ->where('year',$dateOld[1])->lists('id');
        $income = $this->recordRepository->oneWhereSum('period_id',$periodOld[0],'balance');
        $check = $this->checkRepository->oneWhereSum('period_id',$periodOld[0],'balance');
        $balanceSum = $this->balanceChurchRepository->getModel()->whereHas('periods',function($q){
            $dateOld = Session::get('dateOld');
            $q->where('month',12)->where('church_id',1)->where('year',2014);
        })->sum('amount');
        $carbon = new Carbon($dateOld[1].'-'.$dateOld[0].'-1');
        $dateIn =  $dateOld[1].'-'.$dateOld[0].'-1';
        $dateOut =  $dateOld[1].'-'.$dateOld[0].'-'.dayFinish($dateOld[0]);
        $campo = $this->incomeRepository->Campo($dateIn,$dateOut);
        $total = ($balanceSum+($income-$campo)) - $check;
        $data =['period_id'=>$periodOld[0],'date'=>$carbon->endOfMonth()->format('Y-m-d'),'amount'=>$total];
        $balance = $this->balanceChurchRepository->getModel();
        $balance->fill($data);
        $balance->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePeriod($date,$id)
    {
        $dateIn =  $date[1].'-'.$date[0].'-1';
        $dateOut =  $date[1].'-'.$date[0].'-'.dayFinish($date[0]);
        $this->recordRepository->getModel()->whereBetween('saturday',[$dateIn,$dateOut])
            ->update(['period_id'=>$id]);
        $this->checkRepository->getModel()->whereBetween('date',[$dateIn,$dateOut])
            ->update(['period_id'=>$id]);
    }

    public function balance()
    {
        $periods = $this->balanceChurchRepository->allData();
        return view('periods.balancePeriods',compact('periods'));
    }
}
