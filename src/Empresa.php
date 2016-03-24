<?php

class Empresa extends Model {

	protected $id;
	protected $name;
	protected $empleados = array();

	public function setId($value) {
		if(!is_int($value) or (intval($value) <= 0)) {
			throw new InvalidFormatException("Positive integer expected");
		}
		$this->id = $value;
	}

	protected function setEmpleados($value) {
		$this->addEmpleados($empleados);
	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function addEmpleados(array $empleados) {
		foreach($empleados as $newEmpleado) {
			if(!($newEmpleado instanceof Empleado)) {
				throw new InvalidValueException("Array of Empleado expected");
			}
			$this->addEmpleado($newEmpleado);
		}
	}

	public function addEmpleado(Empleado $newEmpleado) {
		if(!$this->empleadoExists($newEmpleado->getId())) {
			$this->empleados[] = $newEmpleado;
		}
	}

	public function empleadoExists($id) {
		return $this->getEmpleado($id) != null;
	}

	public function getEmpleado($id) {
		foreach($this->empleados as $empleado) {
			if($empleado->getId() == $id) {
				return $empleado;
			}
		}
	}

	public function getEmpleados() {
		return $this->empleados;
	}

	public function getAverageAge() {
		// When there's no employees, null is returned.
		if(count($this->getEmpleados()) == 0) {
			return null;
		}

		// Array with employees' ages 
		$edades = array_map(function($empleado) {
			return $empleado->getEdad();
		}, $this->getEmpleados());

		// Sum of ages
		$suma = array_sum($edades);

		return $suma / count($this->getEmpleados());
	}
}