<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/02/16
 * Time: 08:00 PM
 */

namespace SistemasAmigables\Http\Controllers;


use Illuminate\Support\Facades\Input;
use SistemasAmigables\Repositories\AccountRepository;
use SistemasAmigables\Repositories\BankRepository;
use SistemasAmigables\Repositories\CampoRepository;
use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\RecordRepository;

class BankController extends Controller
{
    /**
     * @var BankRepository
     */
    private $bankRepository;
    /**
     * @var AccountRepository
     */
    private $accountRepository;
    /**
     * @var RecordRepository
     */
    private $recordRepository;
    /**
     * @var CheckRepository
     */
    private $checkRepository;
    /**
     * @var CampoRepository
     */
    private $campoRepository;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;

    public function __construct(
        BankRepository $bankRepository,
        AccountRepository $accountRepository,
        RecordRepository $recordRepository,
        CheckRepository $checkRepository,
        CampoRepository $campoRepository,
        IncomeRepository $incomeRepository
    )
    {

        $this->bankRepository = $bankRepository;
        $this->accountRepository = $accountRepository;
        $this->recordRepository = $recordRepository;
        $this->checkRepository = $checkRepository;
        $this->campoRepository = $campoRepository;
        $this->incomeRepository = $incomeRepository;
    }

    public function index()
    {
        $banks = $this->accountRepository->allData();
        return view('banks.index',compact('banks'));
    }


    public function create()
    {

        return view('banks.create');
    }

    public function store()
    {
        $datos = Input::all();

        $account = $this->accountRepository->getModel();
        if($account->isValid($datos)):
            $account->fill($datos);
            $account->save();
            return redirect()->route('bank-ver');
        endif;

        return redirect('iglesia/bancos/create')->withErrors($account)->withInput();

    }


    public function deposit()
    {
        $deposits = $this->bankRepository->allData();
        return view('banks.deposit',compact('deposits'));
    }

    public function estasoCuenta($id)
    {
        $account = $id;
        return view('banks.estadoCuenta',compact('account'));
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-03-02
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
    public function depositCreate()
    {
        $records = $this->recordRepository->getModel()->where('deposit','no')->orderBy('saturday','DESC')->get();
        foreach($records AS $record):
            $bank = 0;
            if(!$record->banks->isEmpty()):
                $bank =$record->banks->sum('balance');
            endif;
            $record->balance = $record->balance - $bank;
        endforeach;
        $accounts = $this->accountRepository->allData();
        return view('banks.depositCreate',compact('records','accounts'));
    }


    public function depositStore()
    {
        $datos = Input::all();
        $datos['type'] = 'entradas';
        if($datos['record_id']==''):
            return redirect()->route('create-deposit')->withErrors('Debe Seleccionar un informe Semanal')->withInput();
        endif;
        $record = $this->recordRepository->token($datos['record_id']);
        $datos['record_id']= $record->id;
        $bank = $this->bankRepository->getModel();
        $accounts = $this->accountRepository->getModel()->find($datos['account_id']);
        $datos['deposit']= 'no';

            if($bank->isValid($datos)):
                $bank->fill($datos);
                $bank->save();

                $bank->records()->attach($datos['record_id']);
                $this->accountRepository->getModel()->where('id',$datos['account_id'])->update(['debit_balance'=>($accounts->debit_balance+$datos['balance']),
                    'balance'=>(($accounts->debit_balance+$datos['balance']+$accounts->initial_balance)-$accounts->credit_balance)]);

                $this->recordUpdate($bank);
                return redirect()->route('deposito-ver');
            endif;


        return redirect()->route('create-deposit')->withErrors($bank)->withInput();
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2016-03-16
    |@Date Update: 2016-00-00
    |---------------------------------------------------------------------
    |@Description: Con esta accion verificamos que los depositos sean
    | Iguales al control interno para actualizar el informe ya fue
    | depositado
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
    public function recordUpdate($bank)
    {

        $amount =  $this->bankRepository->getModel()->where('record_id',$bank->record_id)->sum('balance');

        if($amount == $bank->records[0]->balance):
            $this->recordRepository->getModel()->where('id',$bank->record_id)->update(['deposit'=>'yes']);
        endif;
    }
    public function depositCampo()
    {
        $deposits = $this->campoRepository->getModel()->with('records')->with('checks')->get();
         return view('banks.depositCampo',compact('deposits'));
    }
    public function depositCampoCreate()
    {
        $records = $this->recordRepository->getModel()->where('campo','false')->orderBy('saturday','DESC')->get();
        foreach($records AS $record):
            $campo = $this->campoRepository->getModel()->where('record_id',$record->id)->sum('amount');
            $bank =$this->incomeRepository->amountCampo($record->id);
            $record->balance =  $bank-$campo;
        endforeach;
        $checks = $this->checkRepository->getModel()->where('type','campo')->get();
        foreach($checks AS $check):
            $bank =$this->campoRepository->getModel()->where('check_id',$check->id)->sum('amount');
            
            $check->balance = $check->balance - $bank;
        endforeach;
        return view('banks.depositCampoCreate',compact('records','checks'));
    }

    public function depositCampoStore()
    {
        $datos = Input::all();

        $record = $this->recordRepository->token($datos['record_id']);
        $datos['record_id']= $record->id;
        $account = $this->campoRepository->getModel();
       if($account->isValid($datos)):
            $account->fill($datos);
            $account->save();
           $accounts = $this->campoRepository->getModel()->where('record_id',$record->id)->sum('amount');
           if($accounts == $this->incomeRepository->amountCampo($record->id) ):
                $this->recordRepository->getModel()->where('id',$datos['record_id'])->update(['campo'=>'true']);
            endif;

            return redirect()->route('deposito-campo-ver');
        endif;

        return redirect()->route('create-deposit-campo')->withErrors($account)->withInput();
    }
}
