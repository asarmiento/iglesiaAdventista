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

    public function __construct(
        CheckRepository $checkRepository,
        AccountRepository $accountRepository,
        BankRepository $bankRepository
    )
    {

        $this->checkRepository = $checkRepository;
        $this->accountRepository = $accountRepository;
        $this->bankRepository = $bankRepository;
    }


    public function index(){

        $accounts = $this->accountRepository->allData();

        foreach($accounts AS $account):
            $check = $this->checkRepository->totalOut('account_id',$account->id);
            $total = $account->initial_balance  +$check;
            $bank = $this->bankRepository->oneWhereSum('account_id',$account->id,'balance');
            $totalBank = $account->initial_balance  + $bank;
            $balance = $totalBank - $total;
            echo json_encode(['credit_balance'=>$total,'debit_balance'=>$totalBank,'balance'=>$balance]);

            $this->accountRepository->getModel()->where('id',$account->id)->update(['credit_balance'=>$total,'debit_balance'=>$totalBank,'balance'=>$balance]);
        endforeach;
        die;

        return redirect('/');
    }

    public function updateBank()
    {

    }
}