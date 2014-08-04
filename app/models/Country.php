<?php

class Country extends Eloquent {
	protected $guarded = ['id'];

	public function cities() {
		return $this->hasMany('City');
	}
}