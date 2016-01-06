<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

abstract class Controller extends BaseController {

	use DispatchesJobs, ValidatesRequests;

	/* Con estos methodos enviamos los mensajes de exito en cualquier controlador */

	public function exito($data)
	{
		return Response::json([
			'success' => true,
			'message' => $data,
		]);
	}

	/* Con estos methodos enviamos los mensajes de error en cualquier controlador */

	public function errores($data)
	{
		return Response::json([
			'success' => false,
			'errors' => $data,
		]);
	}


	/**
	 * @return type
	 */
	public function convertionObjeto()
	{
		$datos = Input::all();
		//$DatosController = json_decode($datos);
		return $datos;
	}

	protected function formatValidationErrors(Validator $validator)
	{
		return $validator->errors()->all();
	}
}
