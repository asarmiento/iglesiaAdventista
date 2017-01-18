<?php
/**
 * Created by PhpStorm.
 * User: anwar
 * Date: 07/03/16
 * Time: 04:17 PM
 */

namespace SistemasAmigables\Http\Controllers;


use Illuminate\Support\Facades\Crypt;
use SistemasAmigables\Entities\DepartamentBaseIncome;
use SistemasAmigables\Http\Controllers\Controller;
use SistemasAmigables\Repositories\AccountRepository;
use SistemasAmigables\Repositories\BankRepository;
use SistemasAmigables\Repositories\CheckRepository;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\RecordRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;

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
     * @var TypeIncomeRepository
     */
    private $typeIncomeRepository;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;
    /**
     * @var TypeExpenseRepository
     */
    private $typeExpenseRepository;
    /**
     * @var ExpensesRepository
     */
    private $expensesRepository;

    /**
     * TestController constructor.
     * @param CheckRepository $checkRepository
     * @param AccountRepository $accountRepository
     * @param BankRepository $bankRepository
     * @param RecordRepository $recordRepository
     * @param MemberRepository $memberRepository
     * @param TypeIncomeRepository $typeIncomeRepository
     * @param IncomeRepository $incomeRepository
     * @param DepartamentRepository $departamentRepository
     * @param TypeExpenseRepository $typeExpenseRepository
     * @param ExpensesRepository $expensesRepository
     */
    public function __construct(
        CheckRepository $checkRepository,
        AccountRepository $accountRepository,
        BankRepository $bankRepository,
        RecordRepository $recordRepository,
        MemberRepository $memberRepository,
        TypeIncomeRepository $typeIncomeRepository,
        IncomeRepository $incomeRepository,
        DepartamentRepository $departamentRepository,
        TypeExpenseRepository $typeExpenseRepository,
        ExpensesRepository $expensesRepository
    )
    {

        $this->checkRepository = $checkRepository;
        $this->accountRepository = $accountRepository;
        $this->bankRepository = $bankRepository;
        $this->recordRepository = $recordRepository;
        $this->memberRepository = $memberRepository;
        $this->typeIncomeRepository = $typeIncomeRepository;
        $this->incomeRepository = $incomeRepository;
        $this->departamentRepository = $departamentRepository;
        $this->typeExpenseRepository = $typeExpenseRepository;
        $this->expensesRepository = $expensesRepository;
    }


    public function index(){

        $accounts = $this->incomeRepository->getModel()->groupBy('date')->orderBy('date','ASC')->get();
        $i=104;
        foreach($accounts AS $account):
            $i++;
             $this->incomeRepository->getModel()->where('date',$account->date)->update(['numeration'=>$i]);
        endforeach;
        $members = $this->memberRepository->getModel()->get();
        foreach($members AS $member):

            $this->memberRepository->getModel()->where('id',$member->id)->update(['token'=>Crypt::encrypt($member->name.$member->last)]);
        endforeach;

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
        //UPDATE `type_incomes` SET `balance` = '0' ;
        //UPDATE `type_expenses` SET `balance` = '0' ;
        //UPDATE `departaments` SET `balance` = '0' ;
        $typeIncomes = $this->typeIncomeRepository->getModel()->get();
        $date = ['2016-07-25','2016-11-01'];
        foreach ($typeIncomes AS $typeIncome):
            $amount = $this->incomeRepository->getModel()->where('type_income_id',$typeIncome->id)
                    ->whereHas('records',function($q) use ($date){
                    $q->whereBetween('date',$date);
                })->sum('balance');
            if($typeIncome->association == 'si' && $typeIncome->offering == 'no' && $typeIncome->part == 'no'):
                $balance= $this->typeIncomeRepository->oneWhere('id',$typeIncome->id);
                $newbalance= $balance[0]->balance + $amount;
                $this->typeIncomeRepository->getModel()->where('id',$typeIncome->id)->update(['balance'=>$newbalance]);
            elseif($typeIncome->association == 'si' && $typeIncome->offering == 'si' && $typeIncome->part == 'si'):
                $balance= $this->typeIncomeRepository->newQuery()->where('id',$typeIncome->id)->sum('balance');
                $newbalance= $balance + ($amount*0.6);
                $this->typeIncomeRepository->getModel()->where('id',$typeIncome->id)->update(['balance'=>$newbalance]);
            elseif($typeIncome->association=='no' && $typeIncome->offering == 'si' && $typeIncome->part == 'no'):
                $balance= $this->typeIncomeRepository->oneWhere('id',$typeIncome->id);
                $newbalance= $balance[0]->balance + $amount;
                $this->typeIncomeRepository->getModel()->where('id',$typeIncome->id)->update(['balance'=>$newbalance]);
            elseif($typeIncome->association=='no' && $typeIncome->offering == 'no' && $typeIncome->part == 'no'):
                $balance= $this->typeIncomeRepository->oneWhere('id',$typeIncome->id);
                $newbalance= $balance[0]->balance + $amount;
                $this->typeIncomeRepository->getModel()->where('id',$typeIncome->id)->update(['balance'=>$newbalance]);
            endif;

        endforeach;

        $types = $this->typeIncomeRepository->getModel()->get();

        foreach ($types AS $departament):

                if($departament->base == 'si'):
                    $amount = $this->incomeRepository->getModel()
                            ->whereHas('records',function($q) use ($date){
                             $q->whereBetween('date',$date);
                           })
                        ->whereIn('type_income_id',[2,3])
                        ->sum('balance')*0.6;

                    $amount =   ($amount) * $departament->departament->budget;
                     DepartamentBaseIncome::create([
                        'date'=>'2016-10-24',
                        'amount'=>$amount,
                        'type_income_id'=>$departament->id
                    ]);
                $this->typeIncomeRepository->updateBalance($departament->id,$amount,'balance');
                endif;
        endforeach;


        $departamentos = $this->departamentRepository->getModel()->get();

        foreach ($departamentos AS $departament):
                $amount = $this->typeIncomeRepository->getModel()
                        ->where('departament_id',$departament->id)
                        ->sum('balance');
                $this->departamentRepository->updateBalance($departament->id,$amount,'balance');

        endforeach;

        $typeExpenses = $this->typeExpenseRepository->getModel()->get();

        foreach ($typeExpenses AS $departament):
            $amount = $this->expensesRepository->getModel()
                ->whereBetween('invoiceDate',$date)
                ->where('type_expense_id',$departament->id)
                ->sum('amount');
            $this->typeExpenseRepository->updateBalance($departament->id,$amount,'balance');

        endforeach;

    }

    public function repartir()
    {

    }
}