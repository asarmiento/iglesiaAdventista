<?php

namespace SistemasAmigables\Http\Controllers;

//use AccountHon\Entities\User;
//use AccountHon\Entities\Supplier;
//use AccountHon\Entities\TypeUser;
//use AccountHon\Entities\School;
//use AccountHon\Entities\Menu;
use Illuminate\Support\Facades\Response;
use \DB;
use Crypt;
use Illuminate\Support\Facades\Hash;
use AccountHon\Repositories\UsersRepository;
use AccountHon\Repositories\SchoolsRepository;
use AccountHon\Repositories\MenuRepository;
use AccountHon\Repositories\TypeUserRepository;

class UsersController extends Controller {

 /*   private $usersRepository;
    private $schoolsRepository;
    private $menuRepository;
    private $typeUserRepository;

    /**
     * Create a new controller instance.
     */
  /*  public function __construct(
    UsersRepository $usersRepository, SchoolsRepository $schoolsRepository, MenuRepository $menuRepository, TypeUserRepository $typeUserRepository
    ) {
        $this->usersRepository = $usersRepository;
        $this->schoolsRepository = $schoolsRepository;
        $this->menuRepository = $menuRepository;
        $this->typeUserRepository = $typeUserRepository;
        set_time_limit(0);
        $this->middleware('auth');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $users = $this->usersRepository->withTrashedOrderBy('name', 'ASC');

        return View('users.index', compact('users'));
    }

    public function indexRole() {
        $users = $this->usersRepository->orderBy('id', 'ASC');

        return View('roles.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $typeUsers = $this->typeUserRepository->orderBy('name', 'ASC');
        $schools = $this->schoolsRepository->orderBy('name', 'ASC');
        $menus = $this->menuRepository->orderBy('name', 'ASC');

        return View('users.create', compact('typeUsers', 'suppliers', 'schools', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $users = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($users, 'User');
        $Validation['type_user_id'] =  $users->typeUserIdUser;
        /* Declaramos las clases a utilizar */
        $user = $this->usersRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($user->isValid((array) $Validation)):
            $user->fill($Validation);
            $user->save();

            /* Traemos el id del ultimo registro guardado */
            $schoolsUser = $users->schoolsUser;
            for ($i = 0; $i < count($schoolsUser); $i++):
                /* Comprobamos cuales estan habialitadas y esas las guardamos */
                $Relacion = $this->usersRepository->find($user->id);
                $Relacion->schools()->attach($users->schoolsUser[$i]);
            endfor;

            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($users->statusUser == true):
                $this->usersRepository->withTrashedFind($user->id)->restore();
            else:
                $this->usersRepository->destroy($user->id);
            endif;

            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($user->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $user = $this->usersRepository->withTrashedFind($id);
        $typeUsers = $this->typeUserRepository->orderBy('name', 'ASC');
        $schools = $this->schoolsRepository->orderBy('name', 'ASC');
        $menus = $this->menuRepository->orderBy('name', 'ASC');

        return view('users.edit', compact('user', 'typeUsers', 'suppliers', 'schools', 'menus'));
    }

    public function editRole($id) {
        $user = $this->usersRepository->find($id);
        $menus = $this->menuRepository->orderBy('name', 'ASC');

        return view('roles.edit', compact('user', 'menus'));
    }

    public function updateRole() {
        $roles = $this->convertionObjeto();
        $Menus = $roles->roles;
        $user  = $this->usersRepository->withTrashedFind($roles->idUser);
        $user->Tasks()->detach();
        foreach ($Menus as $idMenu => $value):
            if (!empty($value)) {
                if ($idMenu > 0):
                    $statusTask = $value->statusTasks;
                    for ($e = 0; $e < count($statusTask); $e++):
                        /* Comprobamos cuales estan habialitadas y esas las guardamos */
                        $user = $this->usersRepository->find($roles->idUser);
                        $user->Tasks()->attach($value->idTasks[$e], array('menu_id' => $idMenu, 'status' => $value->statusTasks[$e]));
                    endfor;
                endif;
            }
        endforeach;

        return $this->exito('Los datos se guardaron con exito!!!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id) {

        /* Capturamos los datos enviados por ajax */
        $users = $this->convertionObjeto();
        /* obtenemos dos datos del supplier mediante token recuperamos el id */
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($users, 'User');

        $user = $this->usersRepository->findOrFail($id);
        /* Validamos los datos para guardar tabla menu */
        if ($user->isValid((array) $Validation)):

            $user->update($Validation);

            $schoolsUser = $users->schoolsUser;
            $Relacion = $this->usersRepository->find($id);
            if (!$Relacion->schools->isEmpty()):
                $Relacion->schools()->detach();
            endif;

            for ($i = 0; $i < count($schoolsUser); $i++):
                /* Comprobamos cuales estan habialitadas y esas las guardamos */

                $Relacion->schools()->attach($users->schoolsUser[$i]);
            endfor;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($user->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy() {
        /* Capturamos los datos enviados por ajax */
        $users = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = $this->usersRepository->find($users->idUser)->delete();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se desactivo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    /**
     * Restore the specified typeuser from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function active() {
        /* Capturamos los datos enviados por ajax */
        $users = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = $this->usersRepository->withTrashedFind($users->idUser)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }


}
