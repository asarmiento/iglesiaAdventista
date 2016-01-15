<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 14/01/16
 * Time: 08:17 PM
 */

namespace SistemasAmigables\Http\Controllers;



use Illuminate\Support\Facades\Input;
use SistemasAmigables\Entities\Church;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;

class TypeExpensesController extends Controller
{
    /**
     * @var TypeExpenseRepository
     */
    private $typeExpenseRepository;
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;

    /**
     * TypeExpensesController constructor.
     * @param TypeExpenseRepository $typeExpenseRepository
     * @param DepartamentRepository $departamentRepository
     */
    public function __construct(
        TypeExpenseRepository $typeExpenseRepository,
        DepartamentRepository $departamentRepository

    )
    {

        $this->typeExpenseRepository = $typeExpenseRepository;
        $this->departamentRepository = $departamentRepository;
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-01-14
    |@Date Update: 2016-00-00
    |---------------------------------------------------------------------
    |@Description:
    |
    |
    |@Pasos:
    |
    |
    |
    |
    |
    |
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    public function index()
    {
        $typeExpenses = $this->typeExpenseRepository->allData();
        return view('type_expenses.index',compact('typeExpenses'));
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-00-00
    |@Date Update: 2016-00-00
    |---------------------------------------------------------------------
    |@Description:
    |
    |
    |@Pasos:
    |
    |
    |
    |
    |
    |
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    public function create() {
        $form_data = array('route' => 'typeExp-crear', 'method' => 'POST');
        $action = 'Agregar';
        $typeExpenses = array();
        $iglesia = Church::lists('id');
        $departaments = $this->departamentRepository->allData();
        return View('type_expenses.form', compact('typeExpenses', 'action', 'form_data','iglesia','departaments'));
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-00-00
    |@Date Update: 2016-00-00
    |---------------------------------------------------------------------
    |@Description:
    |
    |
    |@Pasos:
    |
    |
    |
    |
    |
    |
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    public function store() {
        $data = Input::all();
        $typeExpenses = $this->typeExpenseRepository->getModel();

        if ($typeExpenses->isValid($data)) {
            $typeExpenses->fill($data);
            $typeExpenses->save();

            return redirect()->route('typeExp-lista');
        }

        return $this->errores($typeExpenses->errors);
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-01-14
    |@Date Update: 2016-00-00
    |---------------------------------------------------------------------
    |@Description:
    |
    |
    |@Pasos:
    |
    |
    |
    |
    |
    |
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    public function edit($id) {
        $typeExpenses = $this->typeExpenseRepository->getModel()->find($id);
        $form_data = array('route' => array('update-typeExp', $typeExpenses->id), 'method' => 'POST');
        $action = 'Actualizar';
        $iglesia = Church::lists('id');
        $departaments = $this->departamentRepository->allData();
        return View('type_expenses.form', compact('typeExpenses','action','form_data','iglesia','departaments'));
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-00-00
    |@Date Update: 2016-00-00
    |---------------------------------------------------------------------
    |@Description:
    |
    |
    |@Pasos:
    |
    |
    |
    |
    |
    |
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    public function update($id) {
        $data = Input::all();

        $typeExpense = $this->typeExpenseRepository->getModel()->find($id);

        if ($typeExpense->isValid($data)) {
            $typeExpense->fill($data);
            $typeExpense->update();

            return redirect()->route('typeExp-lista');
        }

        return $this->errores($typeExpense->errors);
    }
}