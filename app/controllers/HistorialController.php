<?php

class HistorialController extends \BaseController {

    /**
     * Display a listing of the resource.
     * GET /historial
     *
     * @return Response
     */
    public function index() {
        $informes = Historial::all();
        return View::make('informes.index', compact('informes'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /historial/create
     *
     * @return Response
     */
    public function create() {
        $informes = Historial::all();
        return View::make('informes.create', compact('informes'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /historial
     *
     * @return Response
     */
    public function store() {
        $informes = array('numero'=>'00003','sabado'=>'2015-01-03','saldo'=>'168200.00'); //Input::all();
         $validator = Validator::make($informes, Historial::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Historial::create($informes);
        return Redirect::Route('ingresos.create');
    }

    /**
     * Display the specified resource.
     * GET /historial/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /historial/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /historial/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /historial/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
