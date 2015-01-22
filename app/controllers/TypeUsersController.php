<?php

class TypeUsersController extends \BaseController {

    /**
     * Display a listing of typeusers
     *
     * @return Response
     */
    public function index() {
        $typeusers = TiposUser::withTrashed()->get();
        return View::make('type_users.index', compact('typeusers'));
    }

    /**
     * Show the form for creating a new typeuser
     *
     * @return Response
     */
    public function create() {
        return View::make('type_users.form');
    }

    /**
     * Store a newly created typeuser in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), TiposUser::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Typeuser::create($data);

        return Redirect::route('type_users.index');
    }

    /**
     * Display the specified typeuser.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $typeuser = TiposUser::findOrFail($id);

        return View::make('typeusers.show', compact('typeuser'));
    }

    /**
     * Show the form for editing the specified typeuser.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $typeuser = TiposUser::find($id);

        $form_data = array('route' => array('type_users.update', $typeuser->id), 'method' => 'PATCH');
        $action = 'Editar';
        return View::make('type_users.form', compact('typeuser', 'action', 'form_data'));
    }

    /**
     * Update the specified typeuser in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $typeuser = TiposUser::findOrFail($id);

        $validator = Validator::make($data = Input::all(), TiposUser::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $typeuser->update($data);

        return Redirect::route('type_users.index');
    }

    /**
     * Remove the specified typeuser from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
      $data=  TiposUser::delete($id);
        return $data;
    }

}
