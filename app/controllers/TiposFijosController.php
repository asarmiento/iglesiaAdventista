<?php

class TiposFijosController extends \BaseController {

    /**
     * Display a listing of tiposfijos
     *
     * @return Response
     */
    public function index() {
        $tiposfijos = Tiposfijo::all();

        return View::make('tipos_fijos.index', compact('tiposfijos'));
    }

    /**
     * Show the form for creating a new tiposfijo
     *
     * @return Response
     */
    public function create() {
        $form_data = array('route' => 'tipos_fijos.store', 'method' => 'POST');
        $action = 'Agregar';
        $tiposfijo = array();
        return View::make('tipos_fijos.form',  compact('action','form_data','tiposfijo'));
    }

    /**
     * Store a newly created tiposfijo in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), Tiposfijo::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Tiposfijo::create($data);

        return Redirect::route('tipos_fijos.index');
    }

    /**
     * Display the specified tiposfijo.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $tiposfijo = Tiposfijo::findOrFail($id);

        return View::make('tipos_fijos.show', compact('tiposfijo'));
    }

    /**
     * Show the form for editing the specified tiposfijo.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {        
        $tiposfijo = Tiposfijo::find($id);
        $form_data = array('route' => array('tipos_fijos.update', $tiposfijo->id), 'method' => 'PATCH');
        $action = 'Editar';  
        return View::make('tipos_fijos.form', compact('form_data','tiposfijo','action'));
    }

    /**
     * Update the specified tiposfijo in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $tiposfijo = Tiposfijo::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Tiposfijo::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $tiposfijo->update($data);

        return Redirect::route('tipos_fijos.index');
    }

    /**
     * Remove the specified tiposfijo from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Tiposfijo::destroy($id);

        return Redirect::route('tipos_fijos.index');
    }

}
