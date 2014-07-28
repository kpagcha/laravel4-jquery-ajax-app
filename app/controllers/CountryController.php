<?php

class CountryController extends BaseController {

	public function all() {
		$pages = 5;
		$countries = Country::paginate($pages);

		$html = View::make('countries.list', compact('countries'))->render();
		//return [ 'html' => $html ];
		return Response::json(['html' => $html]);
	}

	public function index()
	{
		return View::make('countries.index');
	}

	public function clear()
	{
		Country::truncate();
		$data = [ 'message' => 'Se ha vaciado la tabla' ];

		return Response::json($data);
	}

	public function store()
	{
		//Input::merge(array_map('trim', Input::except('_token')));
		$input = Input::except('_token');

		$validator = Validator::make($input,
			array(
				'id' => 'unique',
				'name' => 'required',
				'population' => 'numeric'
			)
		);

		$data = [ 'status' => null, 'message' => null, 'errors' => null ];

		if ($validator->passes()) {
			Country::create($input);
			$data['status'] = true;
			$data['message'] = '¡País creado!';
		} else {
			$errors = $validator->messages();
			$data['errors'] = implode('', $errors->all('<li class="alert-warning">:message</li>'));
			$data['status'] = false;
		}

		return Response::json($data);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		Country::find($id)->delete();
	}

}
