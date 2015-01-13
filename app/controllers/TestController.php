<?php

class TestController extends \BaseController {

    public function show() {
//	      $test = Miembro::all();
//            $test = Iglesia::all();
//            $test = Gasto::all();
//            $test = Ingreso::all();
//            $test = Cheque::all();
        echo json_encode($test);
    }

}
