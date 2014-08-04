<?php

class CountryController extends BaseController {

	public function all() {
		$pages = 5;
		$countries = Country::paginate($pages);

		$html = View::make('countries.list', compact('countries'))->render();
		//return [ 'html' => $html ];
		return Response::json(['html' => $html, 'empty' => count($countries) == 0]);
	}

	public function index()
	{
		return View::make('countries.index');
	}

	public function clear()
	{
		DB::statement("SET foreign_key_checks=0");
		Country::truncate();
		DB::statement("SET foreign_key_checks=1");

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

	public function edit($id)
	{
		$country = Country::find($id);
		$html = View::make('countries.edit', compact('country'))->render();
		
		return Response::json(['html' => $html]);
	}

	public function update($id)
	{
		$country = Country::find($id);

		$input = Input::except('_token');

		$validator = Validator::make($input,
			array(
				'id' => 'unique',
				'name' => 'required',
				'population' => 'numeric'
			)
		);

		$data = [ 'status' => null, 'errors' => null ];

		if ($validator->passes()) {
			//$country->update($input);
			$country->name = $input['name'];
			$country->continent = $input['continent'];
			$country->capital = $input['capital'];
			$country->language = $input['language'];
			$country->population = $input['population'];
			$country->currency = $input['currency'];

			if (count($country->getDirty()) > 0) {
				$country->save();
			}

			$data['status'] = true;
		} else {
			$errors = $validator->messages();
			$data['errors'] = implode('', $errors->all('<li class="text-warning">:message</li>'));
			$data['status'] = false;
		}

		return Response::json($data);
	}

	public function destroy($id)
	{
		Country::find($id)->delete();
	}

}
