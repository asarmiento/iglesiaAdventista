<?php namespace SistemasAmigables\Http\Controllers;

class TypesTemporaryIncomeController extends Controller {

    /**
     * Display a listing of tiposvariables
     *
     * @return Response
     */
    public function index() {
        $tiposvariables = Tiposvariable::all();

        return View::make('tipos_variables.index', compact('tiposvariables'));
    }

    /**
     * Show the form for creating a new tiposvariable
     *
     * @return Response
     */
    public function create() {
        $form_data = array('route' => 'tipos_variables.store', 'method' => 'POST');
        $action = 'Agregar';
        $tiposvariable = array();
        return View::make('tipos_variables.form', compact('tiposvariable', 'action', 'form_data'));
    }

    /**
     * Store a newly created tiposvariable in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), Tiposvariable::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Tiposvariable::create($data);

        return Redirect::route('tipos_variables.index');
    }

    /**
     * Display the specified tiposvariable.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $tiposvariable = Tiposvariable::findOrFail($id);

        return View::make('tipos_variables.show', compact('tiposvariable'));
    }

    /**
     * Show the form for editing the specified tiposvariable.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $tiposvariable = Tiposvariable::find($id);
        $form_data = array('route' => array('tipos_variables.update', $tiposvariable->id), 'method' => 'PATCH');
        $action = 'Editar';  
        return View::make('tipos_variables.form', compact('tiposvariable','action','form_data'));
    }

    /**
     * Update the specified tiposvariable in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $tiposvariable = Tiposvariable::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Tiposvariable::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $tiposvariable->update($data);

        return Redirect::route('tipos_variables.index');
    }

    /**
     * Remove the specified tiposvariable from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Tiposvariable::destroy($id);

        return Redirect::route('tipos_variables.index');
    }

}
