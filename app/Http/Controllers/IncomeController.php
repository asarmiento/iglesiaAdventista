<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use SistemasAmigables\Entities\Record;
use SistemasAmigables\Entities\TypeFixedIncome;
use SistemasAmigables\Entities\TypesTemporaryIncome;
use SistemasAmigables\Repositories\IncomeRepository;
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
     * @var IncomeRepository
     */
    private $incomeRepository;

    /**
     * @param RecordRepository $recordRepository
     * @param MemberRepository $memberRepository
     * @param TypeFixedRepository $typeFixedRepository
     * @param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     * @param IncomeRepository $incomeRepository
     */
    public function __construct(
        RecordRepository $recordRepository,
        MemberRepository $memberRepository,
        TypeFixedRepository $typeFixedRepository,
        TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository,
        IncomeRepository $incomeRepository
    )
    {

        $this->recordRepository = $recordRepository;
        $this->memberRepository = $memberRepository;
        $this->typeFixedRepository = $typeFixedRepository;
        $this->typeTemporaryIncomeRepository = $typeTemporaryIncomeRepository;
        $this->incomeRepository = $incomeRepository;
    }
    /**
     * Display a listing of incomes
     *
     * @return Response
     */
    public function index() {
        $incomes = $this->incomeRepository->getModel()->all();
        $members = $this->memberRepository->getModel()->all();
        return View('incomes.index', compact('incomes','members'));
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

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2015-12-23
    |@Date Update: 2015-00-00
    |---------------------------------------------------------------------
    |@Description: con esta acción recibimos mediante post los datos del
    |   formulario de detalles de los sobres y se insertan en la tabla
    |   income
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $datas = $this->dataAbout();
            $control = Input::all();

            $balance = 0;

            foreach ($datas AS $data):
                $record = $this->incomeRepository->getModel();
               $balance += $data['balance'];

                if ($record->isValid($data)):
                    $record->fill($data);
                    $record->save();

                endif;
            endforeach;

            if($balance == $control['balanceControl']):
            DB::commit();
            return redirect()->route('index-income');
            endif;
            return redirect()->route('index-income')->withErrors(['balance'=>'Hay un monto mal no es igual'])
                ->withInput();
            /* Enviamos el mensaje de error */
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('sobres' => 'Verificar la información del cheque, si no contactarse con soporte de la applicación'));
        }
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2015-12-22
    |@Date Update: 2015-00-00
    |---------------------------------------------------------------------
    |@Description: Preparamos los datos recibidos y lo agrupamos en un array
    |   para poder insertarlo individualmente uno por cada tipo ya sea fijo
    |   o variables de cada miembro.
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    private function dataAbout()
    {
        $data = Input::all();

        $i=1;
        $record = $this->recordRepository->token(Input::get('tokenControlNumber'));
        $fixeds = $this->typeFixedRepository->getModel()->get();
        $temps = $this->typeTemporaryIncomeRepository->getModel()->get();

        unset($data['tokenControlNumber']);
        unset($data['_token']);
        $token = md5($record);
        $data = Input::all();

          $transaction = array();

        for($i=1 ; $i<=$record->rows; $i++)
        {
            $numberOf = $data['numberAbout-'.$i];
            $member = $this->memberRepository->token($data['members-'.$i]);

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
                            'member_id' => $member->id,
                            'balance'    => $balance,
                            'token'    => $token,
                            'date'    => $data['date'],
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
                            'member_id' => $member->id,
                            'balance'    => $balance,
                            'token'    => $token,
                            'date'    => $data['date'],
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
    public function showInforme($token) {
        $control = $this->recordRepository->token($token);
        $incomes = $this->incomeRepository->getModel()->where('record_id',$control->id)->get();
        $fixeds=  TypeFixedIncome::all();
        $temporaries=  TypesTemporaryIncome::all();
        $members = $this->memberRepository->getModel()->all();
        return View('incomes.show', compact('incomes','fixeds','temporaries','members'));
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
