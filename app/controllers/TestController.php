<?php 

class TestController extends \BaseController {

	public function show(){
		$test = Miembro::all();
		echo json_encode($test);
	}
}