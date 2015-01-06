<?php

class ChequesController extends \BaseController {

	/**
	 * Display a listing of cheques
	 *
	 * @return Response
	 */
	public function index()
	{
		$cheques = Cheque::all();

		return View::make('cheques.index', compact('cheques'));
	}

	/**
	 * Show the form for creating a new cheque
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('cheques.create');
	}

	/**
	 * Store a newly created cheque in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Cheque::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Cheque::create($data);

		return Redirect::route('cheques.index');
	}

	/**
	 * Display the specified cheque.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$cheque = Cheque::findOrFail($id);

		return View::make('cheques.show', compact('cheque'));
	}

	/**
	 * Show the form for editing the specified cheque.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cheque = Cheque::find($id);

		return View::make('cheques.edit', compact('cheque'));
	}

	/**
	 * Update the specified cheque in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$cheque = Cheque::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Cheque::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$cheque->update($data);

		return Redirect::route('cheques.index');
	}

	/**
	 * Remove the specified cheque from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Cheque::destroy($id);

		return Redirect::route('cheques.index');
	}

}
