<?php

namespace SistemasAmigables\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use SistemasAmigables\Http\Requests;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\CheckRepository;
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

    public function __construct(
        PeriodRepository $periodRepository,
        CheckRepository $checkRepository,
        RecordRepository $recordRepository


    )
    {

        $this->periodRepository = $periodRepository;
        $this->checkRepository = $checkRepository;
        $this->recordRepository = $recordRepository;
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
        $spli = explode("-",$datos['newPeriod']);
        $data = ['month'=>$spli[0],'year'=>$spli[1],'church_id'=>1,'token'=>bcrypt($datos['oldPeriod'])];

        $period = $this->periodRepository->getModel();
        if($period->isValid($data)):
            $period->fill($data);
            $period->save();
            $this->updateFinishBalance($dateOld);
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFinishBalance($dateOld)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
