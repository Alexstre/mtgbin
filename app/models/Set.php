<?php

class Set extends \Eloquent {
	protected $fillable = [];
	public $timestamps = false;

	public function cards() {
		return $this->hasMany('Card');
	}
}