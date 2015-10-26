<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use SistemasAmigables\Entities\Record;
use SistemasAmigables\Entities\TypeFixedIncome;
use SistemasAmigables\Entities\TypesTemporaryIncome;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\RecordRepository;
use SistemasAmigables\Repositories\TypeFixedRepository;
use SistemasAmigables\Repositories\TypeTemporaryIncomeRepository;

class IncomeController extends Controller {
    /**
     * @var RecordRepository
     */
    private $recordRepository;
    /**
     * @var MemberRepository
     */
    private $memberRepository;
    /**
     * @var TypeFixedRepository
     */
    private $typeFixedRepository;
    /**
     * @var TypeTemporaryIncomeRepository
     */
    private $typeTemporaryIncomeRepository;

    /**
     * @param RecordRepository $recordRepository
     * @param MemberRepository $memberRepository
     * @param TypeFixedRepository $typeFixedRepository
     * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     */
    public function __construct(
        RecordRepository $recordRepository,
        MemberRepository $memberRepository,
        TypeFixedRepository $typeFixedRepository,
        TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
    )
    {

        $this->recordRepository = $recordRepository;
        $this->memberRepository = $memberRepository;
        $this->typeFixedRepository = $typeFixedRepository;
        $this->typeTemporaryIncomeRepository = $typeTemporaryIncomeRepository;
    }
    /**
     * Display a listing of incomes
     *
     * @return Response
     */
    public function index() {
        $ingresos = Ingreso::all();
        return View::make('incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new ingreso
     *
     * @return Response
     */
    public function create($token) {

        $fixeds=  TypeFixedIncome::all();
        $temporaries=  TypesTemporaryIncome::all();
        $incomes=  $this->recordRepository->token($token);
        $members = $this->memberRepository->getModel()->all();
        return View('incomes.form', compact('incomes','fixeds','temporaries','members'));

    }

    /**
     * Store a newly created ingreso in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $datas = $this->dataAbout();

            $record = $this->recordRepository->getModel();

            foreach ($datas AS $data):

                if ($record->isValid($data)):
                    $record->fill($data);
                    $record->save();
                else:
                    DB::rollback();
                    return redirect('informes/create')
                        ->withErrors($request->all())
                        ->withInput();

                endif;
            endforeach;
            DB::commit();
            return redirect()->route('create-income', [$record->_token]);
            /* Enviamos el mensaje de error */
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('sobres' => 'Verificar la información del cheque, si no contactarse con soporte de la applicación'));
        }
    }

    private function dataAbout()
    {
        $data = Input::all();

        $i=1;
        $record = $this->recordRepository->token(Input::get('tokenControlNumber'));
        $fixeds = $this->typeFixedRepository->getModel()->count();
        $temps = $this->typeTemporaryIncomeRepository->getModel()->get();

        unset($data['tokenControlNumber']);
        unset($data['_token']);

        $data = Input::all();

          $transaction = array();

        for($i=1 ; $i<=$record->rows; $i++)
        {
            $numberOf = $data['numberAbout-'.$i];
            $member_id = $data['members-'.$i];
            if($numberOf == '' || $numberOf == null)
            {
                continue;
            }

            foreach($fixeds AS $fixed)
            {

                if($data['fixeds-'.$i.'-'.$fixed->id] > 0)
                {
                    $balance = $data['fixeds-'.$i.'-'.$fixed->id];

                    array_push($transaction, array(
                            'record_id' => $record->id,
                            'numberOf' => $numberOf,
                            'member_id' => $member_id,
                            'balance'    => $balance,
                            'typeFixedIncome_id' => $fixed->id,
                            'typesTemporaryIncome_id' => null
                        )
                    );
                }
            }

            foreach($temps AS $temp)
            {

                if(($data['temporary-'.$i.'-'.$temp->id]) > 0)
                {
                    $balance = $data['temporary-'.$i.'-'.$temp->id];

                    array_push($transaction, array(
                            'record_id' => $record->id,
                            'numberOf' => $numberOf,
                            'member_id' => $member_id,
                            'balance'    => $balance,
                            'typeFixedIncome_id' => null,
                            'typesTemporaryIncome_id' => $temp->id
                        )
                    );
                }
            }
        }
       return ($transaction);

    }
    /**
     * Display the specified ingreso.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $ingreso = Ingreso::findOrFail($id);

        return View::make('incomes.show', compact('ingreso'));
    }

    /**
     * Show the form for editing the specified ingreso.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $ingreso = Ingreso::find($id);

        return View::make('incomes.edit', compact('ingreso'));
    }

    /**
     * Update the specified ingreso in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $ingreso = Ingreso::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Ingreso::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $ingreso->update($data);

        return Redirect::route('incomes.index');
    }

    /**
     * Remove the specified ingreso from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Ingreso::destroy($id);

        return Redirect::route('incomes.index');
    }

}
