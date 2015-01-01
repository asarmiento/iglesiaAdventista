<?php

class TiposVariablesController extends \BaseController {

	/**
	 * Display a listing of tiposvariables
	 *
	 * @return Response
	 */
	public function index()
	{
		$tiposvariables = Tiposvariable::all();

		return View::make('tiposvariables.index', compact('tiposvariables'));
	}

	/**
	 * Show the form for creating a new tiposvariable
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('tiposvariables.create');
	}

	/**
	 * Store a newly created tiposvariable in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Tiposvariable::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Tiposvariable::create($data);

		return Redirect::route('tiposvariables.index');
	}

	/**
	 * Display the specified tiposvariable.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tiposvariable = Tiposvariable::findOrFail($id);

		return View::make('tiposvariables.show', compact('tiposvariable'));
	}

	/**
	 * Show the form for editing the specified tiposvariable.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tiposvariable = Tiposvariable::find($id);

		return View::make('tiposvariables.edit', compact('tiposvariable'));
	}

	/**
	 * Update the specified tiposvariable in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tiposvariable = Tiposvariable::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Tiposvariable::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$tiposvariable->update($data);

		return Redirect::route('tiposvariables.index');
	}

	/**
	 * Remove the specified tiposvariable from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tiposvariable::destroy($id);

		return Redirect::route('tiposvariables.index');
	}

}
