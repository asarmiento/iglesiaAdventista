<?php namespace SistemasAmigables\Http\Controllers;
use Illuminate\Support\Facades\Input;
use SistemasAmigables\Entities\Church;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\TypeTemporaryIncomeRepository;

class TypesTemporaryIncomeController extends Controller {
    /**
     * @var TypeTemporaryIncomeRepository
     */
    private $typeTemporaryIncomeRepository;
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;

    /**
     * TypesTemporaryIncomeController constructor.
     * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     * @param DepartamentRepository $departamentRepository
     */
    public function __construct(
        TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository,
        DepartamentRepository $departamentRepository
    )
    {

        $this->typeTemporaryIncomeRepository = $typeTemporaryIncomeRepository;
        $this->departamentRepository = $departamentRepository;
    }
    /**
     * Display a listing of tiposvariables
     *
     * @return Response
     */
    public function index() {
        $tiposvariables = $this->typeTemporaryIncomeRepository->getModel()
            ->selectRaw('types_temporary_incomes.*,
            ( SELECT SUM(balance) FROM incomes WHERE incomes.typesTemporaryIncome_id = types_temporary_incomes.id) as income,
             ( SELECT SUM(amount) FROM expense_income
             WHERE expense_income.types_temporary_income_id = types_temporary_incomes.id) as expense'
            )->with('incomes')->get();

        return View('tipos_variables.index', compact('tiposvariables'));
    }

    /**
     * Show the form for creating a new tiposvariable
     *
     * @return Response
     */
    public function create() {
        $form_data = array('route' => 'crear-variableTypes', 'method' => 'POST');
        $action = 'Agregar';
        $tiposvariable = array();
        $iglesia = Church::lists('id');
        $departaments = $this->departamentRepository->allData();
        return View('tipos_variables.form', compact('tiposvariable', 'action', 'form_data','iglesia','departaments'));
    }

    /**
     * Store a newly created tiposvariable in storage.
     *
     * @return Response
     */
    public function store() {
        $data = Input::all();
        $variableType = $this->typeTemporaryIncomeRepository->getModel();

        if ($variableType->isValid($data)) {
            $variableType->fill($data);
            $variableType->save();

            return redirect()->route('crear-variableType');
        }

        return $this->errores($variableType->errors);
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
        $tiposvariable = $this->typeTemporaryIncomeRepository->getModel()->find($id);
        $form_data = array('route' => array('update-variableTypes', $tiposvariable->id), 'method' => 'POST');
        $action = 'Actualizar';
        $iglesia = Church::lists('id');
        $departaments = $this->departamentRepository->allData();
        return View('tipos_variables.form', compact('tiposvariable','action','form_data','iglesia','departaments'));
    }

    /**
     * Update the specified tiposvariable in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $data = Input::all();
        $variableType = $this->typeTemporaryIncomeRepository->getModel()->find($id);

        if ($variableType->isValid($data)) {
            $variableType->fill($data);
            $variableType->save();

            return redirect()->route('variableType-lista');
        }

        return $this->errores($variableType->errors);
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
