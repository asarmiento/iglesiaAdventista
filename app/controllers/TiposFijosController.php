<?php

class TiposFijosController extends \BaseController {

	/**
	 * Display a listing of tiposfijos
	 *
	 * @return Response
	 */
	public function index()
	{
		$tiposfijos = Tiposfijo::all();

		return View::make('tiposfijos.index', compact('tiposfijos'));
	}

	/**
	 * Show the form for creating a new tiposfijo
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('tiposfijos.create');
	}

	/**
	 * Store a newly created tiposfijo in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Tiposfijo::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Tiposfijo::create($data);

		return Redirect::route('tiposfijos.index');
	}

	/**
	 * Display the specified tiposfijo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tiposfijo = Tiposfijo::findOrFail($id);

		return View::make('tiposfijos.show', compact('tiposfijo'));
	}

	/**
	 * Show the form for editing the specified tiposfijo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tiposfijo = Tiposfijo::find($id);

		return View::make('tiposfijos.edit', compact('tiposfijo'));
	}

	/**
	 * Update the specified tiposfijo in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tiposfijo = Tiposfijo::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Tiposfijo::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$tiposfijo->update($data);

		return Redirect::route('tiposfijos.index');
	}

	/**
	 * Remove the specified tiposfijo from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tiposfijo::destroy($id);

		return Redirect::route('tiposfijos.index');
	}

}
