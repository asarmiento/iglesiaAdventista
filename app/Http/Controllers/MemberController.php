<?php namespace SistemasAmigables\Http\Controllers;



use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use SistemasAmigables\Entities\Church;
use SistemasAmigables\Entities\Member;
use SistemasAmigables\Repositories\MemberRepository;

class MemberController extends Controller {
    /**
     * @var MemberRepository
     */
    private $memberRepository;

    /**
     * @param MemberRepository $memberRepository
     */
    public function __construct(MemberRepository $memberRepository)
    {

        $this->memberRepository = $memberRepository;
    }
    /**
     * Display a listing of members
     *
     * @return Response
     */
    public function index() {
        $members = Member::paginate(100);

        return View('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new miembro
     *
     * @return Response
     */
    public function create() {
        $form_data = array('route' => 'crear-members', 'method' => 'POST');
        $action = 'Agregar';
        $miembro = array();
        $iglesia = Church::lists('id');
        return View('members.form', compact('form_data', 'action', 'miembro', 'iglesia'));
    }

    /**
     * Store a newly created miembro in storage.
     *
     * @return Response
     */
    public function store() {
        try {
            DB::beginTransaction();
        $data = Input::all();

        $members = $this->memberRepository->getModel();
        if ($members->isValid($data)) {
            $members->fill($data);
            $members->save();

        }
            echo json_encode($members);
            die;
            DB::rollback();
            return redirect('miembros/crear')
                ->withErrors($members)
                ->withInput();

        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('sobres' => 'Verificar la información del cheque, si no contactarse con soporte de la applicación'));
        }

    }

    /**
     * Display the specified miembro.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $miembro = Member::findOrFail($id);

        return View::make('members.show', compact('miembro'));
    }

    /**
     * Show the form for editing the specified miembro.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $miembro = Member::find($id);
        $form_data = array('route' => array('members.update', $miembro->id), 'method' => 'PATCH');
        $action = 'Agregar';
        $dropdown = Iglesia::lists('name', 'id');
        return View::make('members.form', compact('form_data', 'action', 'miembro', 'dropdown'));
    }

    /**
     * Update the specified miembro in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $miembro = Member::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Miembro::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $miembro->update($data);

        return Redirect::route('members.index');
    }

    /**
     * Remove the specified miembro from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        Member::destroy($id);

        return Redirect('/miembros');
    }

}
