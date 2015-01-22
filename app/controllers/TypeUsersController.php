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
            if (Request::ajax()):
                return Response::json([
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                ]);
            else:
                return Redirect::back()->withErrors($validator)->withInput();
            endif;
        }
        Typeuser::create($data);
        return 1;
    }

    /**
     * Display the specified typeuser.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $typeuser = TiposUser::findOrFail($id);
        return View::make('typeusers.show', json_encode($typeuser));
    }

    /**
     * Show the form for editing the specified typeuser.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $typeuser = TiposUser::find($id);
        return View::make('type_users.index', json_encode($typeuser));
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
            if (Request::ajax()):
                return Response::json([
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                ]);
            else:
                return Redirect::back()->withErrors($validator)->withInput();
            endif;
        }
        $typeuser->update($data);
        return 1;
    }

    /**
     * Remove the specified typeuser from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $data = TiposUser::destroy($id);
        if ($data):
            return 1;
        endif;

        return json_encode(array('message' => 'Ya esta Inactivo'));
    }

    /**
     * Restore the specified typeuser from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function restore($id) {
        $data = TiposUser::withTrashed()->find($id)->restore();
        if ($data):
            return 1;
        endif;

        return json_encode(array('message' => 'Ya esta activa'));
    }

}
