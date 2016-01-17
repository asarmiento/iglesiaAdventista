<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Validator;
use SistemasAmigables\Entities\Church;
use SistemasAmigables\Entities\TypeIncome;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;

class TypeIncomeController extends Controller {
    /**
     * @var TypeIncomeRepository
     */
    private $TypeIncomeRepository;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var ExpensesRepository
     */
    private $expensesRepository;
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;

    /**
     * TypeFixedIncomeController constructor.
     * @param TypeIncomeRepository $TypeIncomeRepository
     * @param IncomeRepository $incomeRepository
     * @param ExpensesRepository $expensesRepository
     * @param DepartamentRepository $departamentRepository
     */
    public function __construct(
        TypeIncomeRepository $TypeIncomeRepository,
        IncomeRepository $incomeRepository,
        ExpensesRepository $expensesRepository,
        DepartamentRepository $departamentRepository

    )
    {
        $this->TypeIncomeRepository = $TypeIncomeRepository;
        $this->incomeRepository = $incomeRepository;
        $this->expensesRepository = $expensesRepository;
        $this->departamentRepository = $departamentRepository;
    }
    /**
     * Display a listing of tiposfijos
     *
     * @return Response
     */
    public function index() {
        $date = date('Y').'-01-01';

        $tipoincomes = $this->TypeIncomeRepository->getModel()
            ->selectRaw("type_incomes.*,
            ( SELECT SUM(balance) FROM incomes WHERE incomes.type_income_id=type_incomes.id AND date < $date ) as lastYear"
            )->with('incomes')->get();

        return View('tipo_incomes.index', compact('tipoincomes'));
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
        $departaments = $this->departamentRepository->allData();
        return View('tipo_incomes.form',  compact('action','form_data','tiposfijo','iglesia','departaments'));
    }

    /**
     * Store a newly created tiposfijo in storage.
     *
     * @return Response
     */
    public function store() {

        $data = Input::all();
        $typeFix = $this->TypeIncomeRepository->getModel();

        if ($typeFix->isValid($data)) {
            $typeFix->fill($data);
            $typeFix->save();

            return redirect()->route('crear-typeFix');
        }

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
        $tiposfijo = TypeIncome::findOrFail($id);

        return View::make('tipo_incomes.show', compact('tiposfijo'));
    }

    /**
     * Show the form for editing the specified tiposfijo.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {        
        $tiposfijo = $this->TypeIncomeRepository->getModel()->find($id);
        $form_data = array('route' => array('update-typeFixs', $tiposfijo->id), 'method' => 'POST');
        $action = 'Actualizar';
        $iglesia = Church::lists('id');
        $departaments = $this->departamentRepository->allData();
        return View('tipo_incomes.form', compact('form_data','tiposfijo','action','iglesia','departaments'));
    }

    /**
     * Update the specified tiposfijo in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $typeFix = TypeIncome::findOrFail($id);

        $data= Input::all();
        if ($typeFix->isValid($data)) {
            $typeFix->fill($data);
            $typeFix->update();

            return redirect()->route('typeFix-lista');
        }

        return redirect()->route('typeFix-edit')
            ->withErrors($typeFix)
            ->withInput();

    }

    /**
     * Remove the specified tiposfijo from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        TypeIncome::destroy($id);

        return Redirect::route('tipo_incomes.index');
    }

}
