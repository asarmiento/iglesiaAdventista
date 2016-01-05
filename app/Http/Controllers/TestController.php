<?php namespace SistemasAmigables\Http\Controllers;

use SistemasAmigables\Entities\Income;
use SistemasAmigables\Repositories\IncomeRepository;
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
     * TestController constructor.
     * @param IncomeRepository $incomeRepository
     * @param TypeFixedRepository $typeFixedRepository
     * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     */
    public function __construct(
        IncomeRepository $incomeRepository,
        TypeFixedRepository $typeFixedRepository,
        TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
    )
    {

        $this->incomeRepository = $incomeRepository;
        $this->typeFixedRepository = $typeFixedRepository;
        $this->typeTemporaryIncomeRepository = $typeTemporaryIncomeRepository;
    }
    public function show() {
echo 'hola';

        $tipoFijos = $this->typeFixedRepository->allData();

        foreach($tipoFijos AS $tipoFijo):

            $income = $this->incomeRepository->oneWhere('typeFixedIncome_id',$tipoFijo->id);

        $this->typeFixedRepository->updateBalance($tipoFijo->id,$income[0]->balance);
            endforeach;

        $tipoVars = $this->typeTemporaryIncomeRepository->allData();

        foreach($tipoVars AS $tipoVar):

            $income = $this->incomeRepository->oneWhere('typesTemporaryIncome_id',$tipoVar->id);

            $this->typeTemporaryIncomeRepository->updateBalance($tipoVar->id,$income[0]->balance);
        endforeach;


//        $test = TiposVariable::find(1);
//        $test = TiposFijo::find(1);
//        $test = Gasto::find(1);
//        $test = Departamento::find(1);
//        $test = Iglesia::with('Miembro')->get();
//        $test = Miembro::find(26);
//        $test = Ingreso::find(3);
//        $test = Banco::find(1);
//        $test = Historial::find(1);
//        $affectedRows = User::where('votes', '>', 100)->update(array('status' => 2));
//        $test = Iglesia::all();
//        $test = Gasto::all();
//        $test = Cheque::all();
//        $test = Ingreso::all();
//        dd($test->miembro);
// $data= new  TypeUsersController();
// // echo $data->destroy(3);  
//    echo $data->restore(1);  
        
    }

}
