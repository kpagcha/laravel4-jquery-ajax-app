<?php

class CityController extends BaseController {

	public function all() {
		$pages = 5;
		$cities = City::paginate($pages);

		$html = View::make('cities.list', compact('cities'))->render();
		
		return Response::json(['html' => $html, 'empty' => count($cities) == 0, 'countries' => count(Country::all()) > 0]);
	}

	public function index()
	{
		$all_countries = Country::all();
		$countries = [];
		foreach ($all_countries as $key => $value) {
			$countries[$value['id']] = $value['name'];
		}
		return View::make('cities.index', compact('countries'));
	}

	public function clear()
	{
		City::truncate();
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

			$city = new City;
			$city->name = $input['name'];
			$city->population = $input['population'];
			$city->save();
			if (isset($input['country'])) {
				Country::find($input['country'])->cities()->save($city);
			}
			$data['status'] = true;
			$data['message'] = '¡Ciudad creada!';

		} else {

			$errors = $validator->messages();
			$data['errors'] = implode('', $errors->all('<li class="alert-warning">:message</li>'));
			$data['status'] = false;

		}

		return Response::json($data);
	}

	public function edit($id)
	{
		$city = City::find($id);
		$all_countries = Country::all();
		$countries = [];
		foreach ($all_countries as $key => $value) {
			$countries[$value['id']] = $value['name'];
		}
		$country = $city->country ? $city->country->id : null;
		$html = View::make('cities.edit')
			->with('city', $city)
			->with('countries', $countries)
			->with('country', $country)
			->render();
		
		return Response::json(['html' => $html, 'countries' => count($countries) > 0]);
	}

	public function update($id)
	{
		$city = City::find($id);

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
			
			$city->name = $input['name'];
			$city->population = $input['population'];
			if (isset($input['country'])) {
				$city->country()->associate(Country::find($input['country']));
			}

			if (count($city->getDirty()) > 0) {
				$city->save();
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
		City::find($id)->delete();
	}

}