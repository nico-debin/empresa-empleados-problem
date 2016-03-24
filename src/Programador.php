<?php

class Programador extends Empleado {

	protected $language;

	public function setLanguage($value) {
		if(!Languages::isValidLanguage($value)) {
			throw new InvalidValueException("'$value' is not a valid Language");
		}
		$this->language = $value;
	}

	public function getLanguage() {
		return $this->language;
	}
}