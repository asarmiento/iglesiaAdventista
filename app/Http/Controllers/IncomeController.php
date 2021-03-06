<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use SistemasAmigables\Entities\DepartamentBaseIncome;
use SistemasAmigables\Entities\Record;
use SistemasAmigables\Entities\TypeFixedIncome;
use SistemasAmigables\Entities\TypeIncome;
use SistemasAmigables\Entities\TypesTemporaryIncome;
use SistemasAmigables\Repositories\DepartamentRepository;
use SistemasAmigables\Repositories\IncomeRepository;
use SistemasAmigables\Repositories\MemberRepository;
use SistemasAmigables\Repositories\PeriodRepository;
use SistemasAmigables\Repositories\RecordRepository;
use SistemasAmigables\Repositories\TypeIncomeRepository;
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
     * @var TypeIncomeRepository
     */
    private $TypeIncomeRepository;
    /**
     * @var TypeTemporaryIncomeRepository
     */
    private $typeTemporaryIncomeRepository;
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;
    /**
     * @var TypeIncomeRepository
     */
    private $typeIncomeRepository;
    /**
     * @var DepartamentRepository
     */
    private $departamentRepository;
    /**
     * @var PeriodRepository
     */
    private $periodRepository;

    /**
     * @param RecordRepository $recordRepository
     * @param MemberRepository $memberRepository
     * @param TypeIncomeRepository $TypeIncomeRepository
     * @param TypeIncomeRepository $typeIncomeRepository
     * @param IncomeRepository $incomeRepository
     * @param DepartamentRepository $departamentRepository
     * @internal param TypeTemporaryIncomeRepository $typeTemporaryIncomeRepository
     */
    public function __construct(
        RecordRepository $recordRepository,
        MemberRepository $memberRepository,
        TypeIncomeRepository $TypeIncomeRepository,
        TypeIncomeRepository $typeIncomeRepository,
        IncomeRepository $incomeRepository,
        DepartamentRepository $departamentRepository,
        PeriodRepository $periodRepository
    )
    {

        $this->recordRepository = $recordRepository;
        $this->memberRepository = $memberRepository;
        $this->TypeIncomeRepository = $TypeIncomeRepository;
        $this->incomeRepository = $incomeRepository;
        $this->typeIncomeRepository = $typeIncomeRepository;
        $this->departamentRepository = $departamentRepository;
        $this->periodRepository = $periodRepository;
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

        $typeIncomes=  $this->typeIncomeRepository->oneWhere('status','activo');
        $incomes=  $this->recordRepository->token($token);
        $members = $this->memberRepository->getModel()
            ->select(DB::raw("CONCAT(name, ' ', last) as nameCompleto"),'token')->get();
       return View('incomes.form', compact('incomes','typeIncomes','members'));

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
    public function store() {
        try {
            DB::beginTransaction();
            $datas = $this->dataAbout();
            $control = Input::all();
            /** Inicializacion de variables para totales */
            $balance = 0;
            $totalOfrenda =0;
            $totalIglOfrenda =0;
            $totalAsociacion =0;
            $otrosIglesia=[];
            $otrosNoIglesia=[];
            $allIncomeIglesia=[];
            $TotalDiezmos = 0;
            /** Busqueda de los id */
            $diezmos = $this->typeIncomeRepository->treeWhereList('offering','no','part','no','association','si','id');
            $ofrenda = $this->typeIncomeRepository->treeWhereList('part','si','association','si','offering','si','id');
            $otrasAsocOfrendas = $this->typeIncomeRepository->treeWhereList('part','no','association','si','offering','si','id');
            $otrasIglOfrendas = $this->typeIncomeRepository->treeWhereList('part','no','association','no','offering','si','id');
            $otrasIgl = $this->typeIncomeRepository->treeWhereList('part','no','association','no','offering','no','id');
            $allTypeIncomes = $this->typeIncomeRepository->allData();
           // echo json_encode($datas).'</br>';
            foreach ($datas AS $data):

                $record = $this->incomeRepository->getModel();
               $balance += $data['balance'];

               if ($record->isValid($data)):
                    $record->fill($data);
                    $record->save();
                     /** Buscamos los montos para las cantidades para su distribución*/
                if($diezmos[0] == $data['type_income_id']):
                    $totalAsociacion += $data['balance'];
                endif;
                //Ofrenda generarl
                if($ofrenda[0] == $data['type_income_id']):

                    $totalAsociacion += ($data['balance']*0.4);
                    $totalIglOfrenda += ($data['balance']*0.6);
                endif;
                //Fondo de Inversion
                if($ofrenda[1] == $data['type_income_id']):
                    $totalAsociacion += ($data['balance']*0.4);
                    $totalIglOfrenda += ($data['balance']*0.6);
                endif;

                foreach ($otrasAsocOfrendas AS $otrasAsocOfrenda):
                    if($otrasAsocOfrenda == $data['type_income_id']):
                        $totalAsociacion += $data['balance'];
                    endif;
                endforeach;
                foreach ($otrasIglOfrendas AS $otrasOfrenda):
                    if($otrasOfrenda == $data['type_income_id']):
                        if (array_key_exists($otrasOfrenda, $otrosIglesia)) :
                            $value = $data['balance'] + $otrosIglesia[$otrasOfrenda];
                            $otrosIglesia[$otrasOfrenda] = $value;
                            break;
                        endif;
                        $otrosIglesia[$otrasOfrenda] = $data['balance'];
                        break;
                    endif;
                endforeach;

                foreach ($otrasIgl AS $otrasIglesia):
                    if($otrasIglesia == $data['type_income_id']):
                        if (array_key_exists($otrasIglesia, $otrosIglesia)) :
                            $value = $data['balance'] + $otrosIglesia[$otrasIglesia];
                            $otrosIglesia[$otrasIglesia] = $value;
                            break;
                        endif;
                        $otrosIglesia[$otrasIglesia] = $data['balance'];
                    endif;
                endforeach;

                $totalesDepartaments = ['asociacion'=>$totalAsociacion,
                    'iglesia'=>['Ofrenda'=>($totalIglOfrenda),$otrosIglesia,$otrosNoIglesia],'date'=>$data['date']];
                    endif;

            endforeach;

             $this->ingresoDepartaments($totalesDepartaments);

            if($balance == $control['balanceControl']):
            DB::commit();
                return redirect()->route('post-report',$data['date']);
            endif;
            return redirect()->route('index-income')->withErrors(['balance'=>'Hay un monto mal no es igual'])
                ->withInput();
            /* Enviamos el mensaje de error */
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('sobres' => 'Verificar la información del cheque, si no contactarse con soporte de la applicación'));
        }
    }
    public function ingresoBase($datos,$departament)
    {
       if($departament->typeIncomeWhere):
             $amount=   $datos['iglesia']['Ofrenda']*$departament->budget;
            DepartamentBaseIncome::create([
                'date'=>$datos['date'],
                'amount'=>$amount,
                'type_income_id'=>$departament->typeIncomeWhere->id
            ]);
            $this->typeIncomeRepository->updateBalance($departament->typeIncomeWhere->id,$amount,'balance');
       endif;

    }
    /**************************************************
    * @Author: Anwar Sarmiento Ramos
    * @Email: asarmiento@sistemasamigables.com
    * @Create: 11/07/16 06:10 PM   @Update 0000-00-00
    ***************************************************
    * @Description: En esta accion hacemos la distribucion
    * entre todos los departamentos
    *
    *
    * @Pasos:
    * @param $datos
    *
    * @return not
    ***************************************************/

    private function ingresoDepartaments($datos)
    {
        $balanceCampo = $this->departamentRepository->oneWhereSum('type','campo','balance');

        $this->departamentRepository->getModel()->where('type','campo')->update(['balance'=>($datos['asociacion']+$balanceCampo)]);

        $departaments = $this->departamentRepository->oneWhere('type','iglesia');
        foreach ($departaments AS $departament):

            $this->ingresoBase($datos,$departament);
            $this->departamentRepository->getModel()->where('id',$departament->id)
                ->update(['balance'=>(($datos['iglesia']['Ofrenda']*$departament->budget)+$departament->balance)]);
        endforeach;

        foreach ($datos['iglesia'][0] AS $key => $otrosIngresos):

            $type = $this->departamentRepository->getModel()->whereHas('typeIncomes',function ($q) use ($key) {
            $q->where('type_incomes.id',$key);
            })->get();

            $this->departamentRepository->updateBalance($type[0]->id,(($otrosIngresos)),'balance');
        endforeach;

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
        $fixeds = $this->TypeIncomeRepository->oneWhere('status','activo');

        unset($data['tokenControlNumber']);
        unset($data['token']);
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
                    $this->TypeIncomeRepository->updateBalanceAll($fixed,$balance);
                    array_push($transaction, array(
                            'record_id' => $record->id,
                            'numberOf' => $numberOf,
                            'member_id' => $member->id,
                            'balance'    => $balance,
                            'token'    => $token,
                            'date'    => $data['date'],
                            'type_income_id' => $fixed->id
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
        set_time_limit(0);
        $control = $this->recordRepository->token($token);
        $incomes = $this->incomeRepository->getModel()->where('record_id',$control->id)->get();
        $typeIncomes=  $this->typeIncomeRepository->allData();
        $income = $this->incomeRepository->getModel();
        $members = $this->memberRepository->getModel()->all();
        $i =0;
        return View('incomes.show', compact('incomes','typeIncomes','members','income','control','i'));
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

    public function send($token){
        [
            'asociacion' => 372000.0,
            'iglesia' =>array ('Ofrenda' => 108000.0,0 =>array(19 => 30000,22 => 30000,26 => 28000,),1 =>array (),
            'date' => '2016-11-19',
            ),
        ];

    }

    public function estadoCuenta()
    {
        $periods = $this->periodRepository->getModel()->orderBy('year','DESC')->get();
        return view('incomes.estadoCuenta',compact('periods'));
    }


}
