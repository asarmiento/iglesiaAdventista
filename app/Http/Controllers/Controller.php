<?php namespace SistemasAmigables\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

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
		$datos = Input::get('data');
		$DatosController = json_decode($datos);
		return $DatosController;
	}

	protected function formatValidationErrors(Validator $validator)
	{
		return $validator->errors()->all();
	}
}
