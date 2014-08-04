<?php

class City extends Eloquent {
	protected $guarded = ['id'];

	public function country() {
		return $this->belongsTo('Country');
	}
}