<?php

class DirectionsAPIController extends BaseController {

	protected $directionsSearchService;

    public function __construct(Services\Directions\DirectionsSearchService $directionsSearchService) {
        $this->directionsSearchService = $directionsSearchService;
    }

    public function search() {
        return $this->directionsSearchService->search(Input::all());
    }
    
}