<?php

class SetupController extends BaseController {
    
    public function getIndex(){
          $conn = DB::connection("diurno");
          $paginacion = $conn->table("informacion")->get();
        return View::make('setup.index',array('resultado'=>$paginacion));
    }
    public function getEdit(){
        $conn = DB::connection("diurno");
          $paginacion = $conn->table("informacion")
                  ->where('id',$_GET['id'])
                  ->get();
         return View::make('setup.edit',array('resultado'=>$paginacion));
    }
    public function postEdit(){
           $input = Input::all();
       $reglas = array(
           'cedula'=>'required',
           'junta'=>'required',
           'nombre'=>'required',
           'circuito'=>'required',
           'codigo'=>'required',
           'fuente'=>'required',
           'periodo'=>'required',
           'director'=>'required',
           'presidente'=>'required',
           'secretario'=>'required',
           'contador'=>'required',
           'linea1'=>'required',
           'linea2'=>'required'
       );
       $mensaje =array(
           'required'=>'Este campo es obligatorio',
       );
       $validar = Validator::make($input,$reglas,$mensaje);
       if($validar->fails()):
           return Redirect::back()->withErrors($validar);
       else:
        $conn = DB::connection("diurno");
       $conn->update("update informacion set cedula = '".$input['cedula']  
               ."', nombre = '".$input['nombre']  
               ."', junta = '".$input['junta']  
               ."', linea1 = '".$input['linea1']  
               ."', linea2 = '".$input['linea2']  
               ."', circuito = '".$input['circuito']  
               ."', codigo = '".$input['codigo']  
               ."', fuente_financiamiento = '".$input['fuente']  
               ."', periodo = '".$input['periodo']  
               ."', director = '".$input['director']  
               ."', secretario = '".$input['secretario']  
               ."', presidente = '".$input['presidente']  
               ."', contador = '".$input['contador']  
               ."' where id = ?", array($input['id']));
      return Redirect::to('setup');
        endif;
    }
}