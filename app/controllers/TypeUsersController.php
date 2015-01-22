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
      
    }

    /**
     * Store a newly created typeuser in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::json()->all(), TiposUser::$rules);

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
      
    }

    /**
     * Show the form for editing the specified typeuser.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
       
    }

    /**
     * Update the specified typeuser in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update() {
        
       $validator = Validator::make($data = Input::json()->all(), TiposUser::$rules);

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
        
        $data = TiposUser::onlyTrashed()->find($id);
        
        if ($data):
            $data->restore();
            return 1;
        endif;

        return json_encode(array('message' => 'Ya esta activa'));
    }

}
