<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use SistemasAmigables\Entities\ExpenseTypeExpense;
use SistemasAmigables\Entities\Income;
use SistemasAmigables\Repositories\ExpensesRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\TypeExpenseRepository;
use SistemasAmigables\Repositories\TypeFixedRepository;
use SistemasAmigables\Repositories\TypeTemporaryIncomeRepository;

class TestController extends Controller {
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var TypeFixedRepository
     */
    private $typeFixedRepository;
    /**
     * @var TypeTemporaryIncomeRepository
     */
    private $typeTemporaryIncomeRepository;
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
     * @param TypeFixedRepository $typeFixedRepository
     * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     * @param MemberRepository $memberRepository
     * @param TypeExpenseRepository $typeExpenseRepository
     * @param ExpensesRepository $expensesRepository
     */
    public function __construct(
        IncomeRepository $incomeRepository,
        TypeFixedRepository $typeFixedRepository,
        TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository,
        MemberRepository $memberRepository,
        TypeExpenseRepository $typeExpenseRepository,
        ExpensesRepository $expensesRepository

    )
    {

        $this->incomeRepository = $incomeRepository;
        $this->typeFixedRepository = $typeFixedRepository;
        $this->typeTemporaryIncomeRepository = $typeTemporaryIncomeRepository;
        $this->memberRepository = $memberRepository;
        $this->typeExpenseRepository = $typeExpenseRepository;
        $this->expensesRepository = $expensesRepository;
    }
    public function show() {


        $tipoFijos = $this->typeFixedRepository->allData();

        foreach($tipoFijos AS $tipoFijo):
           $incomes = $this->incomeRepository->oneWhereList('typeFixedIncome_id',$tipoFijo->id);
           $this->typeFixedRepository->updateBalance($tipoFijo->id,$incomes);
        endforeach;

        $tipoVars = $this->typeTemporaryIncomeRepository->allData();

        foreach($tipoVars AS $tipoVar):
            $incomes = $this->incomeRepository->oneWhereList('typesTemporaryIncome_id',$tipoVar->id);
            $this->typeTemporaryIncomeRepository->updateBalance($tipoVar->id,$incomes);
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

}
