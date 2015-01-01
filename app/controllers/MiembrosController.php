<?php

class MiembrosController extends \BaseController {

	/**
	 * Display a listing of miembros
	 *
	 * @return Response
	 */
	public function index()
	{
		$miembros = Miembro::all();

		return View::make('miembros.index', compact('miembros'));
	}

	/**
	 * Show the form for creating a new miembro
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('miembros.create');
	}

	/**
	 * Store a newly created miembro in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Miembro::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Miembro::create($data);

		return Redirect::route('miembros.index');
	}

	/**
	 * Display the specified miembro.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$miembro = Miembro::findOrFail($id);

		return View::make('miembros.show', compact('miembro'));
	}

	/**
	 * Show the form for editing the specified miembro.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$miembro = Miembro::find($id);

		return View::make('miembros.edit', compact('miembro'));
	}

	/**
	 * Update the specified miembro in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$miembro = Miembro::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Miembro::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$miembro->update($data);

		return Redirect::route('miembros.index');
	}

	/**
	 * Remove the specified miembro from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Miembro::destroy($id);

		return Redirect::route('miembros.index');
	}

}
