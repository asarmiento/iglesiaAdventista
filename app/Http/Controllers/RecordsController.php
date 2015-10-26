<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use SistemasAmigables\Entities\Record;
use SistemasAmigables\Repositories\RecordRepository;

class RecordsController extends Controller {
    /**
     * @var RecordRepository
     */
    private $recordRepository;

    /**
     * @param RecordRepository $recordRepository
     */
    public function __construct(RecordRepository $recordRepository)
    {

        $this->recordRepository = $recordRepository;
    }
    /**
     * Display a listing of the resource.
     * GET /historial
     *
     * @return Response
     */
    public function index() {
        $informes = $this->recordRepository->getModel()->all();
        return View('informes.index', compact('informes'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /historial/create
     *
     * @return Response
     */
    public function create() {
        $informes = Record::all();
        $consecutive = $informes[0]->numbers+1;
        return View('informes.create', compact('informes','consecutive'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /historial
     *
     * @return Response
     */
    public function store(Request $request) {

      //  $validator = Validator::make($request->all(), $this->recordRepository->getModel()->getRules());

        $record= $this->recordRepository->getModel();
        if ($record->isValid($request->all())):
            $record->fill($request->all());
            $record->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            /* Enviamos el mensaje de guardado correctamente */
            return redirect()->route('create-income', [$record->_token]);
        endif;
        /* Enviamos el mensaje de error */
        return redirect('informes/create')
            ->withErrors($request->all())
            ->withInput();
    }

    /**
     * Display the specified resource.
     * GET /historial/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /historial/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /historial/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /historial/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
