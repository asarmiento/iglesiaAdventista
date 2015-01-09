<?php

class IngresosController extends \BaseController {

    /**
     * Display a listing of ingresos
     *
     * @return Response
     */
    public function index() {
        $ingresos = Ingreso::all();
        return View::make('ingresos.index', compact('ingresos'));
    }

    /**
     * Show the form for creating a new ingreso
     *
     * @return Response
     */
    public function create() {
        $form_data = array('route' => 'ingresos.store', 'method' => 'POST');
        $fijos=  TiposFijo::all();
        $variables=  TiposVariable::all();
        $miembros = Miembro::paginate(10);
        $action="Agregar";
        $ingresos = array();
        return View::make('ingresos.form', compact('ingresos', 'action', 'form_data','fijos','variables','miembros'));
    }

    /**
     * Store a newly created ingreso in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), Ingreso::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Ingreso::create($data);

        return Redirect::route('ingresos.index');
    }

    /**
     * Display the specified ingreso.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $ingreso = Ingreso::findOrFail($id);

        return View::make('ingresos.show', compact('ingreso'));
    }

    /**
     * Show the form for editing the specified ingreso.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $ingreso = Ingreso::find($id);

        return View::make('ingresos.edit', compact('ingreso'));
    }

    /**
     * Update the specified ingreso in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $ingreso = Ingreso::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Ingreso::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $ingreso->update($data);

        return Redirect::route('ingresos.index');
    }

    /**
     * Remove the specified ingreso from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Ingreso::destroy($id);

        return Redirect::route('ingresos.index');
    }

}
