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

    public function __construct(
        CheckRepository $checkRepository,
        AccountRepository $accountRepository
    )
    {

        $this->checkRepository = $checkRepository;
        $this->accountRepository = $accountRepository;
    }


    public function index(){

        $accounts = $this->accountRepository->allData();

        foreach($accounts AS $account):
            $check = $this->checkRepository->totalOut('account_id',$account->id);
            $total = $account->credit_balance +$check;

            $this->accountRepository->getModel()->where('id',$account->id)->update(['credit_balance'=>$total]);
        endforeach;

        return redirect('/');
    }
}