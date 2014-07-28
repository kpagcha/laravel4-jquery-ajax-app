<?php

use Illuminate\Support\ServiceProvider;

class DirectionsSearchService extends ServiceProvider {

	public function register() {
		$this->app->bind('DirectionsSearchService', function() {
			return new DirectionsSearchService;
		});
	}

	public function search($input = array()) {
		$origin = $input['origin'];
		$destination = $input['destination'];
		$mode = $input['mode'];

		$url = "http://maps.googleapis.com/maps/api/directions/json?origin=" . $origin . "&destination=" . $destination . "&mode=" . $mode . "&sensor=false&language=es";

		$json = json_decode(file_get_contents(str_replace(" ", "%20", $url)), true);

		$result = var_export($json, true);

		$data = [
			'url' => $url,
			'status' => $json['status'],
			'origin' => '',
			'destination' => '',
			'distance' => '',
			'duration' => '',
			'route' => [
				'step' => [],
				'distance' => [],
				'duration' => [],
				'mode' => [],
				'distance_value' => []
			],
			'distance_value' => ''
		];

		if ($data['status'] == 'OK') {
			$data['origin'] = $json['routes'][0]['legs'][0]['start_address'];
			$data['destination'] = $json['routes'][0]['legs'][0]['end_address'];
			$data['distance'] = $json['routes'][0]['legs'][0]['distance']['text'];
			$data['duration'] = $json['routes'][0]['legs'][0]['duration']['text'];
			foreach ($json['routes'][0]['legs'][0]['steps'] as $key => $value) {
			 	array_push($data['route']['step'], $value['html_instructions']);
			 	array_push($data['route']['distance'], $value['distance']['text']);
			 	array_push($data['route']['duration'], $value['duration']['text']);
			 	array_push($data['route']['mode'], $value['travel_mode']);
			 	array_push($data['route']['distance_value'], $value['distance']['value']);
			}
			$data['distance_value'] = $json['routes'][0]['legs'][0]['distance']['value'];
		}

		return $data;
	}
}