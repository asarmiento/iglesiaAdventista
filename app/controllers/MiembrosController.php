<?php

class MiembrosController extends \BaseController {

    /**
     * Display a listing of miembros
     *
     * @return Response
     */
    public function index() {
        $miembros = Miembro::paginate(10);

        return View::make('miembros.index', compact('miembros'));
    }

    /**
     * Show the form for creating a new miembro
     *
     * @return Response
     */
    public function create() {
        $form_data = array('route' => 'miembros.store', 'method' => 'POST');
        $action = 'Agregar';
        $miembro = array();
        $dropdown = Iglesia::lists('name', 'id');
        return View::make('miembros.form', compact('form_data', 'action', 'miembro', 'dropdown'));
    }

    /**
     * Store a newly created miembro in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), Miembro::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Miembro::create($data);

        return Redirect::to('miembros');
    }

    /**
     * Display the specified miembro.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $miembro = Miembro::findOrFail($id);

        return View::make('miembros.show', compact('miembro'));
    }

    /**
     * Show the form for editing the specified miembro.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $miembro = Miembro::find($id);
        $form_data = array('route' => array('miembros.update', $miembro->id), 'method' => 'PATCH');
        $action = 'Agregar';
        $dropdown = Iglesia::lists('name', 'id');
        return View::make('miembros.form', compact('form_data', 'action', 'miembro', 'dropdown'));
    }

    /**
     * Update the specified miembro in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $miembro = Miembro::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Miembro::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $miembro->update($data);

        return Redirect::route('miembros.index');
    }

    /**
     * Remove the specified miembro from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Miembro::destroy($id);

        return Redirect::route('miembros.index');
    }

}
