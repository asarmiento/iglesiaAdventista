<?php

class TypeUsersController extends \BaseController {

	/**
	 * Display a listing of typeusers
	 *
	 * @return Response
	 */
	public function index()
	{
		$typeusers = Typeuser::all();

		return View::make('typeusers.index', compact('typeusers'));
	}

	/**
	 * Show the form for creating a new typeuser
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('typeusers.create');
	}

	/**
	 * Store a newly created typeuser in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Typeuser::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Typeuser::create($data);

		return Redirect::route('typeusers.index');
	}

	/**
	 * Display the specified typeuser.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$typeuser = Typeuser::findOrFail($id);

		return View::make('typeusers.show', compact('typeuser'));
	}

	/**
	 * Show the form for editing the specified typeuser.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$typeuser = Typeuser::find($id);

		return View::make('typeusers.edit', compact('typeuser'));
	}

	/**
	 * Update the specified typeuser in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$typeuser = Typeuser::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Typeuser::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$typeuser->update($data);

		return Redirect::route('typeusers.index');
	}

	/**
	 * Remove the specified typeuser from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Typeuser::destroy($id);

		return Redirect::route('typeusers.index');
	}

}
