<?php namespace SistemasAmigables\Http\Controllers;

use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeFixedRepository;
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
	 * @var TypeFixedRepository
	 */
	private $typeFixedRepository;

	/**
	 * ExpenseController constructor.
	 * @param ExpensesRepository $expensesRepository
	 * @param CheckRepository $checkRepository
	 * @param DepartamentRepository $departamentRepository
	 * @param TypeExpenseRepository $typeExpenseRepository
	 * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
	 * @param TypeFixedRepository $typeFixedRepository
	 */
	public function __construct(
		ExpensesRepository $expensesRepository,
		CheckRepository $checkRepository,
		DepartamentRepository $departamentRepository,
		TypeExpenseRepository $typeExpenseRepository,
		TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository,
		TypeFixedRepository $typeFixedRepository
	)
	{

		$this->expensesRepository = $expensesRepository;
		$this->checkRepository = $checkRepository;
		$this->departamentRepository = $departamentRepository;
		$this->typeExpenseRepository = $typeExpenseRepository;
		$this->typeTemporaryIncomeRepository = $typeTemporaryIncomeRepository;
		$this->typeFixedRepository = $typeFixedRepository;
	}
	/**
	 * Display a listing of expenses
	 *
	 * @return Response
	 */
	public function index()
	{
		$expenses = $this->expensesRepository->allData();

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
		$total= $this->expensesRepository->oneWhereList('check_id',$id,'amount');
		$typeExpenses= $this->typeExpenseRepository->allData();
		$typeFixs = $this->typeFixedRepository->allData();
		$typeVars = $this->typeTemporaryIncomeRepository->allData();
		return View('expenses.create',compact('checks','departaments',
			'expenses','total','typeExpenses','typeFixs','typeVars'));
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
			if($gasto['typeExpenses']):
				$expenses->typeExpenses()->attach($gasto['typeExpenses'],['balance'=>$expenses->amount]);
				$this->typeExpenseRepository->updatesOutBalance($gasto['typeExpenses'],$expenses->amount,'balance');
			endif;
			if($gasto['typeVar']):
				$expenses->expenseVarIncome()->attach($gasto['typeVar'],['amount'=>$expenses->amount]);
				$this->typeTemporaryIncomeRepository->updatesOutBalance($gasto['typeVar'],$expenses->amount,'balance');
			endif;
			if($gasto['typefix']):
				$expenses->expenseFixIncome()->attach($gasto['typefix'],['amount'=>$expenses->amount]);
				$this->typeFixedRepository->updatesOutBalance($gasto['typefix'],$expenses->amount,'balance');
			endif;
			$this->departamentRepository->updatesOutBalance($expenses->departament_id,$expenses->amount,'balance');
			return redirect()->route('create-gasto',$gasto['check_id']);
		endif;

		return redirect('iglesia/cheques/create')->withErrors($expenses)->withInput();
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
		$monto = $this->expensesRepository->oneWhereList('check_id',$token,'amount');
		return View('expenses.show', compact('cheques','gastos','monto'));
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
	public function destroy($id)
	{
		Gasto::destroy($id);

		return Redirect::route('expenses.index');
	}

}
