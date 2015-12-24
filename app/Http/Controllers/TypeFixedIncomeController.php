<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Support\Facades\Input;
use SistemasAmigables\Entities\Church;
use SistemasAmigables\Repositories\TypeFixedRepository;

class TypeFixedIncomeController extends Controller {
    /**
     * @var TypeFixedRepository
     */
    private $typeFixedRepository;

    /**
     * TypeFixedIncomeController constructor.
     * @param TypeFixedRepository $typeFixedRepository
     */
    public function __construct(
        TypeFixedRepository $typeFixedRepository
    )
    {
        $this->typeFixedRepository = $typeFixedRepository;
    }
    /**
     * Display a listing of tiposfijos
     *
     * @return Response
     */
    public function index() {
        $tiposfijos = $this->typeFixedRepository->getModel()->all();

        return View('tipos_fijos.index', compact('tiposfijos'));
    }

    /**
     * Show the form for creating a new tiposfijo
     *
     * @return Response
     */
    public function create() {
        $form_data = array('route' => 'crear-typeFixs', 'method' => 'POST');
        $action = 'Agregar';
        $tiposfijo = array();
        $iglesia = Church::lists('id');
        return View('tipos_fijos.form',  compact('action','form_data','tiposfijo','iglesia'));
    }

    /**
     * Store a newly created tiposfijo in storage.
     *
     * @return Response
     */
    public function store() {

        $data = Input::all();
        $typeFix = $this->typeFixedRepository->getModel();

        if ($typeFix->isValid($data)) {
            $typeFix->fill($data);
            $typeFix->save();

            return redirect()->route('crear-typeFix');
        }
        echo json_encode($typeFix);
        die;
        return redirect()->route('crear-typeFix')
            ->withErrors($typeFix)
            ->withInput();

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
        $tiposfijo = $this->typeFixedRepository->find($id);
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
