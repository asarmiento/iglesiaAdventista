<?php

namespace SistemasAmigables\Http\Controllers;

use Illuminate\Http\Request;

use SistemasAmigables\Http\Requests;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\PeriodRepository;

class PeriodsController extends Controller
{
    /**
     * @var PeriodRepository
     */
    private $periodRepository;

    public function __construct(
        PeriodRepository $periodRepository
    )
    {

        $this->periodRepository = $periodRepository;
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
        $periods = ['old'=>$period->month.'-'.$period->year,'new'=>($period->month+1).'-'.$period->year];
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
