<?php

abstract class Empleado extends Model {

	protected $id;
	protected $firstName;
	protected $lastName;
	protected $birthDate; // YYYY-MM-DD

	public function setId($value) {
		if(!is_int($value) or (intval($value) <= 0)) {
			throw new InvalidFormatException("Positive integer expected");
		}
		$this->id = $value;
	}

	public function setBirthDate($value) {
		if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
			throw new InvalidFormatException("Invalid date format");
		}

		$this->birthDate = $value;
	}

	public function getId() {
		return $this->id;
	}

	public function getFirstName() {
		return $this->firstName;
	}

	public function getLastName() {
		return $this->lastName;
	}

	public function getBirthDate() {
		return $this->birthDate;
	}

	public function getEdad() {
		$dateNow = new DateTime('now');
		$dateBirth = new DateTime($this->birthDate);
		return $dateNow->diff($dateBirth)->y;
	}
}