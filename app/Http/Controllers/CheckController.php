<?php namespace SistemasAmigables\Http\Controllers;



use Anouar\Fpdf\Facades\Fpdf;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use SistemasAmigables\Entities\Check;
use SistemasAmigables\Entities\Expense;
use SistemasAmigables\Repositories\AccountRepository;
use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\ExpensesRepository;

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
	 * @var ExpensesRepository
	 */
	private $expensesRepository;

	/**
	 * CheckController constructor.
	 * @param AccountRepository $accountRepository
	 * @param CheckRepository $checkRepository
	 * @param ExpensesRepository $expensesRepository
	 */
	public function __construct(
		AccountRepository $accountRepository,
		CheckRepository $checkRepository,
		ExpensesRepository $expensesRepository
	)
	{

		$this->accountRepository = $accountRepository;
		$this->checkRepository = $checkRepository;
		$this->expensesRepository = $expensesRepository;
	}
	/**
	 * Display a listing of checks
	 *
	 * @return Response
	 */
	public function index()
	{   $checks = Check::orderBy('number','DESC')->get();
               
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

	/*
	|---------------------------------------------------------------------
	|@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
	|@Date Create: 2016-00-00
	|@Date Update: 2016-04-22
	|---------------------------------------------------------------------
	|@Description: Se agrega el token al registrar cada cheque.
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
	public function store()
	{
		$check = $this->convertionObjeto();

		$very = $this->checkRepository->oneWhere('number',$check['number']);

		if(!$very->isEmpty()):
			return redirect('iglesia/cheques/create')
				->with(['message'=>'EL Cheque numero #: '.$check['number'].' ya Existe ']);
		endif;
		$checks = $this->checkRepository->getModel();
		$check['token']= md5($check['number']);
		if($checks->isValid($check)):
			$checks->fill($check);
			$checks->save();
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

	/*
	|---------------------------------------------------------------------
	|@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
	|@Date Create: 2016-04-22
	|@Date Update: 2016-00-00
	|---------------------------------------------------------------------
	|@Description: Generaremos el pdf del desglose se los gastos realizasos
	| con cada cheque.
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
	public function pdf($token)
	{
		$check = $this->checkRepository->token($token);


		$pdf = Fpdf::AddPage('p','letter');
		$pdf .= Fpdf::SetAuthor('Anwar Sarmiento');
		$pdf .= Fpdf::SetCreator('Anwar Sarmiento');
		$pdf .= Fpdf::SetTitle('Informes de Cheques');
		// Set font
		$pdf .= Fpdf::SetFont('Arial','B',16);
		$pdf .= Fpdf::Cell(0,7,utf8_decode('Asociación Central Sur de Costa Rica de los Adventista del Séptimo Día'),0,1,'C');
		$pdf .= Fpdf::Cell(0,7,utf8_decode('Apartado 10113-1000 San José, Costa Rica'),0,1,'C');
		$pdf .= Fpdf::Cell(0,7,utf8_decode('Teléfonos: 2224-8311 Fax:2225-0665'),0,1,'C');
		$pdf .= Fpdf::Cell(0,7,utf8_decode('acscrtesoreria07@gmail.com acscr_tesoreria@hotmail.com'),0,1,'C');
		$pdf .= Fpdf::Ln();
		$pdf .= Fpdf::Cell(0,7,utf8_decode('Informe detallado de Cheque de la Iglesia de Quepos'),0,1,'C');
		$pdf .= Fpdf::Ln();
		$pdf .= Fpdf::SetFont('Arial','B',14);
		$pdf .= Fpdf::SetX(20);
		$pdf .= Fpdf::Cell(100,7,utf8_decode('Emitido a: '.$check->name),0,0,'C');
		$pdf .= Fpdf::Cell(100,7,utf8_decode('Numero Cheque: '.$check->number),0,1,'C');
		$pdf .= Fpdf::Cell(80,7,utf8_decode('fecha: '.$check->date),0,0,'C');
		$pdf .= Fpdf::Cell(80,7,utf8_decode('Monto: ¢ '.number_format($check->balance,2)),0,1,'C');

		$pdf .= Fpdf::Ln();
		$pdf .= Fpdf::SetFont('Arial','B',12);
		$pdf .= Fpdf::Cell(17,7,utf8_decode('Factura'),1,0,'C');
		$pdf .= Fpdf::Cell(20,7,utf8_decode('Fecha'),1,0,'C');
		$pdf .= Fpdf::Cell(80,7,utf8_decode('Detalle'),1,0,'C');
		$pdf .= Fpdf::Cell(30,7,utf8_decode('Tipo Gasto'),1,0,'C');
		$pdf .= Fpdf::Cell(30,7,utf8_decode('Departamento'),1,0,'C');
		$pdf .= Fpdf::Cell(25,7,utf8_decode('Monto'),1,1,'C');
		$expenses = $this->expensesRepository->oneWhere('check_id',$check->id);
		$total=0;
		foreach($expenses AS $expense):
		$pdf .= Fpdf::SetFont('Arial','I',8);
		$pdf .= Fpdf::Cell(17,7,utf8_decode($expense->invoiceNumber),1,0,'C');
		$pdf .= Fpdf::Cell(20,7,utf8_decode($expense->invoiceDate),1,0,'C');
		$pdf .= Fpdf::Cell(80,7,utf8_decode($expense->detail),1,0,'C');
		$pdf .= Fpdf::Cell(30,7,utf8_decode(substr($expense->typeExpenses->name,0,22)),1,0,'C');
		$pdf .= Fpdf::Cell(30,7,utf8_decode($expense->typeExpenses->departaments[0]->name),1,0,'C');
		$pdf .= Fpdf::Cell(25,7,number_format($expense->amount,2),1,1,'C');
		$total  += $expense->amount;
		endforeach;
		$pdf .= Fpdf::SetFont('Arial','BI',8);
		$pdf .= Fpdf::Cell(177,7,utf8_decode('Total'),1,0,'R');
		$pdf .= Fpdf::Cell(25,7,number_format($total,2),1,1,'C');
		Fpdf::Output();
		exit;
	}



}
