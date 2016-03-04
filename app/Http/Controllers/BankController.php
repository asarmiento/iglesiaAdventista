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

    public function __construct(
        BankRepository $bankRepository,
        AccountRepository $accountRepository,
        RecordRepository $recordRepository,
        CheckRepository $checkRepository,
        CampoRepository $campoRepository
    )
    {

        $this->bankRepository = $bankRepository;
        $this->accountRepository = $accountRepository;
        $this->recordRepository = $recordRepository;
        $this->checkRepository = $checkRepository;
        $this->campoRepository = $campoRepository;
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


    public function depositCreate()
    {
        $records = $this->recordRepository->getModel()->where('deposit','no')->orderBy('saturday','DESC')->get();
        foreach($records AS $record):
            $bank =$this->bankRepository->getModel()->where('record_id',$record->id)->sum('balance');
            $record->balance = $record->balance - $bank;
        endforeach;
        $accounts = $this->accountRepository->allData();
        return view('banks.depositCreate',compact('records','accounts'));
    }


    public function depositStore()
    {
        $datos = Input::all();
        $datos['type'] = 'entradas';
        $record = $this->recordRepository->token($datos['record_id']);
        $datos['record_id']= $record->id;
        $account = $this->bankRepository->getModel();
        $accounts = $this->accountRepository->getModel()->find($datos['account_id']);
        if($account->isValid($datos)):
            $account->fill($datos);
            $account->save();

            $this->accountRepository->getModel()->where('id',$datos['account_id'])->update(['debit_balance'=>($accounts->debit_balance+$datos['balance']),
                'balance'=>(($accounts->debit_balance+$datos['balance']+$accounts->initial_balance)-$accounts->credit_balance)]);

            $this->recordUpdate($datos);
            return redirect()->route('deposito-ver');
        endif;

        return redirect()->route('create-deposit')->withErrors($account)->withInput();
    }

    public function recordUpdate($datos)
    {
        $record = $this->recordRepository->getModel()->find($datos['record_id']);

        $amount = $this->bankRepository->getModel()->where('record_id',$record->id)->sum('balance');

        if($record->balance == $datos['balance']):
              $this->recordRepository->getModel()->where('id',$record->id)->update(['deposit'=>'yes']);
        elseif($amount == $record->balance):

            $this->recordRepository->getModel()->where('id',$record->id)->update(['deposit'=>'yes']);

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
        $accounts = $this->recordRepository->getModel()->find($datos['record_id']);
        if($account->isValid($datos)):
            $account->fill($datos);
            $account->save();
            $this->recordRepository->getModel()->where('id',$datos['record_id'])->update(['campo'=>'true']);


            return redirect()->route('deposito-campo-ver');
        endif;

        return redirect()->route('create-deposit-campo')->withErrors($account)->withInput();
    }
}