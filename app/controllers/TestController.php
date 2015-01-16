<?php

class TestController extends \BaseController {

    public function show() {
       
//$test = TiposVariable::find(1);
// $test = TiposFijo::find(1);
      //  $test = Gasto::find(1);
      //  $test = Departamento::find(1);
     //   $test = Iglesia::find(1);
      //  $test = Miembro::find(26);
      //  $test = Ingreso::find(3);
//        $test = Banco::find(1);
        $test = Historial::find(1);
        //$affectedRows = User::where('votes', '>', 100)->update(array('status' => 2));
//            $test = Iglesia::all();
//            $test = Gasto::all();
//            $test = Cheque::all();
//            $test = Ingreso::all();
      
   //     dd($test->miembro);
        echo $test->banco;
    }
}
