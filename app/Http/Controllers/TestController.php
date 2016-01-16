<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use SistemasAmigables\Entities\ExpenseTypeExpense;
use SistemasAmigables\Entities\Income;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;


class TestController extends Controller {
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var TypeIncomeRepository
     */
    private $typeIncomeRepository;

    /**
     * @var MemberRepository
     */
    private $memberRepository;
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
     * @param IncomeRepository $incomeRepository
     * @param TypeIncomeRepository $TypeIncomeRepository
     * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     * @param MemberRepository $memberRepository
     * @param TypeExpenseRepository $typeExpenseRepository
     * @param ExpensesRepository $expensesRepository
     */
    public function __construct(
        IncomeRepository $incomeRepository,
        TypeIncomeRepository $typeIncomeRepository,

        MemberRepository $memberRepository,
        TypeExpenseRepository $typeExpenseRepository,
        ExpensesRepository $expensesRepository

    )
    {

        $this->incomeRepository = $incomeRepository;
        $this->TypeIncomeRepository = $typeIncomeRepository;

        $this->memberRepository = $memberRepository;
        $this->typeExpenseRepository = $typeExpenseRepository;
        $this->expensesRepository = $expensesRepository;
    }
    public function show() {


        $tipoFijos = $this->typeIncomeRepository->allData();

        foreach($tipoFijos AS $tipoFijo):
           $incomes = $this->incomeRepository->oneWhereList('typeFixedIncome_id',$tipoFijo->id);
           $this->typeIncomeRepository->updateBalance($tipoFijo->id,$incomes);
        endforeach;




    }

    public function token()
    {
        $members= $this->memberRepository->allData();

        foreach ($members as $member) {
            $this->memberRepository->getModel()->where('id',$member->id)->update(['_token'=>Crypt::encrypt($member->name)]);
        }
    }

    public function trasladoExpense()
    {

        $types = $this->typeExpenseRepository->allData();
        foreach($types AS $type):
                $expenses = ExpenseTypeExpense::where('type_expense_id',$type->id)->get();
                foreach($expenses AS $expense):
                    $this->expensesRepository->getModel()->where('id',$expense->expense_id)->update(['type_expense_id'=>$type->id]);
                endforeach;
        endforeach;
    }

    public function typeExpense() {

        $tipoFijos = $this->typeExpenseRepository->allData();

        foreach($tipoFijos AS $tipoFijo):
            $incomes = $this->expensesRepository->oneWhereList('type_expense_id',$tipoFijo->id,'amount');
            $this->typeExpenseRepository->updateBalance($tipoFijo->id,$incomes,'balance');
        endforeach;
    }

    public function typeIncome() {

        $tipoFijos = $this->TypeIncomeRepository->allData();

        foreach($tipoFijos AS $tipoFijo):
            $incomes = $this->incomeRepository->oneWhereList('type_income_id',$tipoFijo->id,'balance');
            $this->TypeIncomeRepository->updateBalance($tipoFijo->id,$incomes,'balance');
        endforeach;
    }

}
