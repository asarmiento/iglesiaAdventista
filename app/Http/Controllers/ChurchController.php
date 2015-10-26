<?php namespace SistemasAmigables\Http\Controllers;

class ChurchController extends Controller {

    /**
     * Display a listing of iglesias
     *
     * @return Response
     */
    public function index() {
        $iglesias = Iglesia::withTrashed()->get();

        return View::make('iglesias.index', compact('iglesias'));
    }

    /**
     * Show the form for creating a new iglesia
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created iglesia in storage.
     *
     * @return Response
     */
    public function store() {
        $json = Input::get('data');
        $data = json_decode($json);

        $iglesia = new Iglesia;

        if ($iglesia->isValid((array) $data)):
            $iglesia->phone = $data->phone;
            $iglesia->address = Str::upper($data->address);
            $iglesia->name = Str::upper($data->name);
            $iglesia->save();
            return 1;
        endif;

        if (Request::ajax()):
            return Response::json([
                        'success' => false,
                        'errors' => $iglesia->errors
            ]);
        else:
            return Redirect::back()->withErrors($iglesia->errors)->withInput();
        endif;
    }

    /**
     * Display the specified iglesia.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified iglesia.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified iglesia in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update() {
        //capturamos los datos enviados
        $json = Input::get('data');       
        $data = json_decode($json);
        
        //hacemos el cambio de estado de acuerdo a lo solicitado
        if ($data->state == 1):
            Iglesia::withTrashed()->find($data->id)->restore();
        else:
            Iglesia::destroy($data->id);
        endif;
        //enviamos a buscar los datos a editar
        $Iglesia = Iglesia::withTrashed()->find($data->id);
        // si no existe enviamos un mensaje de error via json
        if (is_null($Iglesia)):
            return View::make('iglesia.index', json_encode(array('message' => 'La Iglesia no existe')));
        endif;
        
        //validamos los datos
        if ($Iglesia->isValid((array) $data)):
            //si estan correctos los editamos
            $Iglesia->phone = $data->phone;
            $Iglesia->address = Str::upper($data->address);
            $Iglesia->name = Str::upper($data->name);
            $Iglesia->save();
            return 1;
        endif;
        //si estan incorrecto enviamos mensaje via ajax 
        if (Request::ajax()):
            return Response::json([
                        'success' => false,
                        'errors' => $Iglesia->errors
            ]);
        else:
            return Redirect::back()->withErrors($Iglesia->errors)->withInput();
        endif;
    }

    /**
     * Remove the specified iglesia from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $data = Iglesia::destroy($id);
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

        $data = Iglesia::onlyTrashed()->find($id);

        if ($data):
            $data->restore();
            return 1;
        endif;

        return json_encode(array('message' => 'Ya esta activa'));
    }

}
