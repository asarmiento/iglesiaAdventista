<?php namespace SistemasAmigables\Http\Controllers;

class ExpenseController extends Controller {

	/**
	 * Display a listing of gastos
	 *
	 * @return Response
	 */
	public function index()
	{
		$gastos = Gasto::all();

		return View::make('gastos.index', compact('gastos'));
	}

	/**
	 * Show the form for creating a new gasto
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('gastos.create');
	}

	/**
	 * Store a newly created gasto in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Gasto::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Gasto::create($data);

		return Redirect::route('gastos.index');
	}

	/**
	 * Display the specified gasto.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$gasto = Gasto::findOrFail($id);

		return View::make('gastos.show', compact('gasto'));
	}

	/**
	 * Show the form for editing the specified gasto.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$gasto = Gasto::find($id);

		return View::make('gastos.edit', compact('gasto'));
	}

	/**
	 * Update the specified gasto in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$gasto = Gasto::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Gasto::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$gasto->update($data);

		return Redirect::route('gastos.index');
	}

	/**
	 * Remove the specified gasto from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Gasto::destroy($id);

		return Redirect::route('gastos.index');
	}

}
