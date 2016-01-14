<?php namespace SistemasAmigables\Http\Controllers;

use SistemasAmigables\Entities\Church;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\ExpensesRepository;

class DepartamentsController extends Controller {
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;
    /**
     * @var ExpensesRepository
     */
    private $expensesRepository;

    /**
     * DepartamentsController constructor.
     * @param DepartamentRepository $departamentRepository
     * @param ExpensesRepository $expensesRepository
     */
    public function __construct(
        DepartamentRepository $departamentRepository,
        ExpensesRepository $expensesRepository
    )
    {

        $this->departamentRepository = $departamentRepository;
        $this->expensesRepository = $expensesRepository;
    }
    /**
     * Display a listing of departamentos
     *
     * @return Response
     */
    public function index() {
        $departaments = $this->departamentRepository->getModel()->selectRaw('departaments.*,
             ( SELECT SUM(amount) FROM expenses
             WHERE expenses.departament_id = departaments.id) as expense'
        )->with('expenses')->get();
        $totalExpenses  = $this->expensesRepository->getModel()->sum('amount');
        $totalPresupuesto = $this->departamentRepository->getModel()->sum('budget');
        return View('departamentos.index', compact('departaments','totalExpenses','totalPresupuesto'));
    }

    /**
     * Show the form for creating a new departamento
     *
     * @return Response
     */
    public function create() {
        $form_data = array('route' => 'depart-store', 'method' => 'POST');
        $action = 'Agregar';
        $departamentos = array();
        $church = Church::lists('id');
        return View('departamentos.form', compact('departamentos', 'action', 'form_data', 'church'));
    }

    /**
     * Store a newly created departamento in storage.
     *
     * @return Response
     */
    public function store() {
        $validator = Validator::make($data = Input::all(), Departamento::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        Departamento::create($data);

        return Redirect::route('departamentos.index');
    }

    /**
     * Display the specified departamento.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $departamento = Departamento::findOrFail($id);

        return View::make('departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified departamento.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $departamento = Departamento::find($id);

        return View::make('departamentos.edit', compact('departamento'));
    }

    /**
     * Update the specified departamento in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $departamento = Departamento::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Departamento::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $departamento->update($data);

        return Redirect::route('departamentos.index');
    }

    /**
     * Remove the specified departamento from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Departamento::destroy($id);

        return Redirect::route('departamentos.index');
    }

}
