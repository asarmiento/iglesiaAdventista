<?php

class TestController extends \BaseController {

    public function show() {
        $test = Banco::find(2);
        //$affectedRows = User::where('votes', '>', 100)->update(array('status' => 2));
//            $test = Iglesia::all();
//            $test = Gasto::all();
//            $test = Cheque::all();
//            $test = Ingreso::all();
        echo $test->cheques;
    }
}
