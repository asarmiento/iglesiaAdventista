<?php

class IglesiasController extends \BaseController {
    
    protected $dropdown=array(''=>'Elija una Misión','2'=>'Misión Norte','1'=>'Asociación Central','3'=>'Misión del Caribe');
      
    /**
     * Display a listing of iglesias
     *
     * @return Response
     */
    public function index() {
        $iglesias = Iglesia::all();

        return View::make('iglesias.index', compact('iglesias'));
    }

    /**
     * Show the form for creating a new iglesia
     *
     * @return Response
     */
    public function create() {         
        $form_data = array('route' => 'iglesias.store', 'method' => 'POST');
        $action = 'Agregar';
        $iglesia = array();
        $dropdown=$this->dropdown;
        return View::make('iglesias.form',  compact('form_data','action','iglesia','dropdown'));
    }

    /**
     * Store a newly created iglesia in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), Iglesia::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Iglesia::create($data);

        return Redirect::to('iglesias');
    }

    /**
     * Display the specified iglesia.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $iglesia = Iglesia::findOrFail($id);

        return View::make('iglesias.show', compact('iglesia'));
    }

    /**
     * Show the form for editing the specified iglesia.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $iglesia = Iglesia::find($id);
        $form_data = array('route' => array('iglesias.update', $iglesia->id), 'method' => 'PATCH');
        $action = 'Editar';
        $dropdown=$this->dropdown;
        return View::make('iglesias.form',  compact('form_data','action','iglesia','dropdown'));
    }

    /**
     * Update the specified iglesia in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $iglesia = Iglesia::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Iglesia::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $iglesia->update($data);

        return Redirect::route('iglesias.index');
    }

    /**
     * Remove the specified iglesia from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Iglesia::destroy($id);

        return Redirect::to('iglesias');
    }

}
