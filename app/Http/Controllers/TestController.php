<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/03/16
 * Time: 04:17 PM
 */

namespace SistemasAmigables\Http\Controllers;


use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\AccountRepository;
use SistemasAmigables\Repositories\BankRepository;
use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\RecordRepository;

class TestController extends Controller
{

    /**
     * @var CheckRepository
     */
    private $checkRepository;
    /**
     * @var AccountRepository
     */
    private $accountRepository;
    /**
     * @var BankRepository
     */
    private $bankRepository;
    /**
     * @var RecordRepository
     */
    private $recordRepository;
    /**
     * @var MemberRepository
     */
    private $memberRepository;

    /**
     * TestController constructor.
     * @param CheckRepository $checkRepository
     * @param AccountRepository $accountRepository
     * @param BankRepository $bankRepository
     * @param RecordRepository $recordRepository
     * @param MemberRepository $memberRepository
     */
    public function __construct(
        CheckRepository $checkRepository,
        AccountRepository $accountRepository,
        BankRepository $bankRepository,
        RecordRepository $recordRepository,
        MemberRepository $memberRepository
    )
    {

        $this->checkRepository = $checkRepository;
        $this->accountRepository = $accountRepository;
        $this->bankRepository = $bankRepository;
        $this->recordRepository = $recordRepository;
        $this->memberRepository = $memberRepository;
    }


    public function index(){

        $accounts = $this->accountRepository->allData();

        foreach($accounts AS $account):
            $check = $this->checkRepository->totalOut('account_id',$account->id);
            $total = $account->initial_balance  + $check;
            $bank = $this->bankRepository->oneWhereSum('account_id',$account->id,'balance');
            $totalBank = $account->initial_balance  + $bank;
            $balance = $totalBank - $total;

            $this->accountRepository->getModel()->where('id',$account->id)->update(['credit_balance'=>$total,'debit_balance'=>$totalBank,'balance'=>$balance]);
        endforeach;


        return redirect('/');
    }

    public function updateToken()
    {
        $checks = $this->memberRepository->allData();
        foreach($checks AS $check):
            $this->memberRepository->getModel()->where('id',$check->id)->update(['token'=>md5($check->name)]);
        endforeach;
    }

    public function saldoChurch()
    {
        $mes =[1,2];

        $records = $this->recordRepository->oneWhereSum();
    }

    public function repartir()
    {

    }
}