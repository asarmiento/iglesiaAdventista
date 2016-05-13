<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\TransfersRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;
use SistemasAmigables\Repositories\TypeTemporaryIncomeRepository;

class ExpenseController extends Controller {
	/**
	 * @var ExpensesRepository
	 */
	private $expensesRepository;
	/**
	 * @var CheckRepository
	 */
	private $checkRepository;
	/**
	 * @var DepartamentRepository
	 */
	private $departamentRepository;
	/**
	 * @var TypeExpenseRepository
	 */
	private $typeExpenseRepository;
	/**
	 * @var TypeTemporaryIncomeRepository
	 */
	private $typeTemporaryIncomeRepository;
	/**
	 * @var TypeIncomeRepository
	 */
	private $typeIncomeRepository;
	/**
	 * @var TransfersRepository
	 */
	private $transfersRepository;

	/**
	 * ExpenseController constructor.
	 * @param ExpensesRepository $expensesRepository
	 * @param CheckRepository $checkRepository
	 * @param DepartamentRepository $departamentRepository
	 * @param TypeExpenseRepository $typeExpenseRepository
	 * @param TypeIncomeRepository $typeIncomeRepository
	 * @param TransfersRepository $transfersRepository
	 * @internal param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
	 * @internal param TypeIncomeRepository $TypeIncomeRepository
	 */
	public function __construct(
		ExpensesRepository $expensesRepository,
		CheckRepository $checkRepository,
		DepartamentRepository $departamentRepository,
		TypeExpenseRepository $typeExpenseRepository,
		TypeIncomeRepository $typeIncomeRepository,
		TransfersRepository $transfersRepository
	)
	{

		$this->expensesRepository = $expensesRepository;
		$this->checkRepository = $checkRepository;
		$this->departamentRepository = $departamentRepository;
		$this->typeExpenseRepository = $typeExpenseRepository;
		$this->typeIncomeRepository = $typeIncomeRepository;
		$this->transfersRepository = $transfersRepository;
	}
	/**
	 * Display a listing of expenses
	 *
	 * @return Response
	 */
	public function index()
	{
		$expenses = $this->expensesRepository->getModel()
			->select('expenses.*' , 'type_expenses.*' , 'type_expenses.balance')
			->join('type_expenses','type_expenses.id','=','expenses.type_expense_id')
			->with('departaments')->get();

		return View('expenses.index', compact('expenses'));
	}

	/**
	 * Show the form for creating a new gasto
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$checks = $this->checkRepository->getModel()->find($id);
		$departaments = $this->departamentRepository->allData();
		$expenses= $this->expensesRepository->oneWhere('check_id',$id);
		$total= $this->expensesRepository->oneWhereSum('check_id',$id,'amount');
		$typeExpenses= $this->typeExpenseRepository->allData();
		$typeFixs = $this->TypeIncomeRepository->allData();
		return View('expenses.create',compact('checks','departaments',
			'expenses','total','typeExpenses','typeFixs'));
	}

	/**
	 * Store a newly created gasto in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$gasto = $this->convertionObjeto();

		$expenses = $this->expensesRepository->getModel();

		if($expenses->isValid($gasto)):
			$expenses->fill($gasto);
			$expenses->save();

			$this->typeExpenseRepository->updatesOutBalance($expenses->type_expense_id,$expenses->amount,'balance');
			return redirect()->route('create-gasto',$gasto['check_id']);
		endif;

		return redirect('iglesia/gastos/create/'.$gasto['check_id'])->withErrors($expenses)->withInput();
	}

	/**
	 * Display the specified gasto.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($token)
	{

		$cheques = $this->checkRepository->getModel()->find($token);
		$gastos = $this->expensesRepository->oneWhere('check_id',$token);
		$monto = $this->expensesRepository->oneWhereSum('check_id',$token,'amount');

		return View('expenses.show', compact('cheques','gastos','monto'));
	}

	/*
	|---------------------------------------------------------------------
	|@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
	|@Date Create: 2016-04-06
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
	public function viewInd() {
		$typeExpenses = $this->typeExpenseRepository->getModel()->get();
		$departaments = $this->departamentRepository->allData();
		return View('expenses.showInd',compact('typeExpenses','departaments'));
	}
	/**
	 * Show the form for editing the specified gasto.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$gasto = Gasto::find($id);

		return View::make('expenses.edit', compact('gasto'));
	}

	/**
	 * Update the specified gasto in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$gasto = Gasto::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Gasto::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$gasto->update($data);

		return Redirect::route('expenses.index');
	}

	/**
	 * Remove the specified gasto from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteExpense($id)
	{
		$expense=$this->expensesRepository->getModel()->find($id);

		$this->expensesRepository->getModel()->destroy($id);

		return Redirect::route('create-gasto',$expense->check_id);
	}

	public function trapaso()
	{
		$departaments = $this->departamentRepository->allData();
		return view('expenses.traspaso',compact('departaments'));
	}

	public function trapasoStore()
	{
		$datos = Input::all();

		$gastoLocal = $this->typeExpenseRepository->oneWhere('name','Votos de Junta Autorizaciones');



		$income   = [
			'date'=>$datos['date'],
			'departament_id'=>$datos['departament_id'],
			'detail'=>$datos['detail'],
			'vote'=>$datos['votoTraspaso'],
			'amount'=>$datos['amountTraspaso'],
			'type'=>'entrada'];

		$expenses = [
			'date'=>$datos['date'],
			'departament_id'=>$gastoLocal[0]['departament_id'],
			'detail'=>$datos['detail'],
			'vote'=>$datos['votoTraspaso'],
			'amount'=>$datos['amountTraspaso'],
			'type'=>'salida'];

		$transfer = $this->transfersRepository->getModel();

		if($transfer->isValid($income)):
			$transfer->fill($income);
			$transfer->save();
		endif;
		$transfer = $this->transfersRepository->getModel();
		if($transfer->isValid($expenses)):
			$transfer->fill($expenses);
			$transfer->save();
		endif;

		return redirect()->route('ddd-store');
	}

}
