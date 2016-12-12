<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Validator;
use SistemasAmigables\Entities\Church;
use SistemasAmigables\Entities\TypeExpense;
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
            ( SELECT SUM(incomes.balance) FROM incomes
            WHERE incomes.date < $date ) as lastYear"
            )->get();

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

    /**************************************************
    * @Author: Anwar Sarmiento Ramos
    * @Email: asarmiento@sistemasamigables.com
    * @Create: 08/07/16 06:13 PM   @Update 2016-07-08
    ***************************************************
    * @Description:
    *
    *
    *
    * @Pasos:
    *
    *
    * @return view
    ***************************************************/
    public function edit($id) {        
        $tiposfijo = $this->TypeIncomeRepository->getModel()->find($id);
        $iglesia = Church::lists('id');
        $departaments = $this->departamentRepository->allData();
        return View('tipo_incomes.edit', compact('tiposfijo','iglesia','departaments'));
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

    /**************************************************
    * @Author: Anwar Sarmiento Ramos
    * @Email: asarmiento@sistemasamigables.com
    * @Create: 08/07/16 08:54 PM   @Update 0000-00-00
    ***************************************************
    * @Description: Se activara el tipo de ingreso para
    * que aparesca en los informes de ingreso.
    *
    *
    * @Pasos:
    *
    *
    * @return
    ***************************************************/
    public function active($id) {
        TypeIncome::where('id',$id)->update(['status'=>'activo']);

        return redirect()->route('typeFix-lista');
    }
    /**************************************************
    * @Author: Anwar Sarmiento Ramos
    * @Email: asarmiento@sistemasamigables.com
    * @Create: 08/07/16 08:55 PM   @Update 0000-00-00
    ***************************************************
    * @Description: Se Desactivara el tipo de ingreso para
     * que aparesca en los informes de ingreso.
    *
    *
    *
    * @Pasos:
    *
    *
    * @return
    ***************************************************/
    public function desactive($id) {

        TypeIncome::where('id',$id)->update(['status'=>'inactivo']);
        return redirect()->route('typeFix-lista');
    }

    public function relation(){
        $typeIncomes = TypeIncome::orderBY('name','ASC')->get();
        $typeExpenses = TypeExpense::all();
        return view('tipo_incomes.relation',compact('typeIncomes','typeExpenses'));
    }

    public function relationSave()
    {
        $data = Input::all();
        $typeIncomes = TypeIncome::find($data['type_income_id']);
        $typeIncomes->typeExpenses()->attach($data['type_expense_id']);
        return redirect()->route('realacionar-typeFix');
    }
}
