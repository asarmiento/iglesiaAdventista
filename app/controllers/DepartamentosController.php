<?php

class DepartamentosController extends \BaseController {

	/**
	 * Display a listing of departamentos
	 *
	 * @return Response
	 */
	public function index()
	{
		$departamentos = Departamento::all();

		return View::make('departamentos.index', compact('departamentos'));
	}

	/**
	 * Show the form for creating a new departamento
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('departamentos.create');
	}

	/**
	 * Store a newly created departamento in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Departamento::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Departamento::create($data);

		return Redirect::route('departamentos.index');
	}

	/**
	 * Display the specified departamento.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$departamento = Departamento::findOrFail($id);

		return View::make('departamentos.show', compact('departamento'));
	}

	/**
	 * Show the form for editing the specified departamento.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$departamento = Departamento::find($id);

		return View::make('departamentos.edit', compact('departamento'));
	}

	/**
	 * Update the specified departamento in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$departamento = Departamento::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Departamento::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$departamento->update($data);

		return Redirect::route('departamentos.index');
	}

	/**
	 * Remove the specified departamento from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Departamento::destroy($id);

		return Redirect::route('departamentos.index');
	}

}
