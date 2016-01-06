<?php namespace SistemasAmigables\Http\Controllers;



use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use SistemasAmigables\Entities\Check;
use SistemasAmigables\Entities\Expense;
use SistemasAmigables\Repositories\AccountRepository;
use SistemasAmigables\Repositories\CheckRepository;

class CheckController extends Controller {
	/**
	 * @var AccountRepository
	 */
	private $accountRepository;
	/**
	 * @var CheckRepository
	 */
	private $checkRepository;

	/**
	 * CheckController constructor.
	 * @param AccountRepository $accountRepository
	 * @param CheckRepository $checkRepository
	 */
	public function __construct(
		AccountRepository $accountRepository,
		CheckRepository $checkRepository
	)
	{

		$this->accountRepository = $accountRepository;
		$this->checkRepository = $checkRepository;
	}
	/**
	 * Display a listing of checks
	 *
	 * @return Response
	 */
	public function index()
	{   $checks = Check::all();
               
		return View('checks.index', compact('checks'));
	}

	/**
	 * Show the form for creating a new cheque
	 *
	 * @return Response
	 */
	public function create()
	{
		$accounts = $this->accountRepository->allData();
		return View('checks.create', compact('accounts'));
	}

	/**
	 * Store a newly created cheque in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$check = $this->convertionObjeto();

		$checks = $this->checkRepository->getModel();

		if($checks->isValid($check)):
			$checks->fill($check);
			$checks->save();
			$checks->accounts()->attach($checks->account_id,['balance'=>($checks->balance*-1)]);
			$this->accountRepository->updateBalance($checks->account_id,$checks->balance,'balance');
			return redirect()->route('create-gasto',$checks->id);
		endif;

		return redirect('iglesia/cheques/create')->withErrors($checks)->withInput();
	}

	/**
	 * Display the specified cheque.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$cheque = Cheque::findOrFail($id);

		return View::make('checks.show', compact('cheque'));
	}

	/**
	 * Show the form for editing the specified cheque.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cheque = Cheque::find($id);

		return View::make('checks.edit', compact('cheque'));
	}

	/**
	 * Update the specified cheque in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$cheque = Cheque::find($id);

		$validator = Validator::make($data = Input::all(), Cheque::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$cheque->update($data);

		return Redirect::route('checks.index');
	}

	/**
	 * Remove the specified cheque from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Cheque::destroy($id);

		return Redirect::route('checks.index');
	}

}
