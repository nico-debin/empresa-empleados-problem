<?php

class Diseniador extends Empleado {

	protected $tipoDiseniador;

	public function setTipoDiseniador($value) {
		if(!TipoDiseniador::isValidTipo($value)) {
			throw new InvalidValueException("'$value' is not a valid TipoDiseniador");
		}
		$this->tipoDiseniador = $value;
	}

	public function getTipoDiseniador() {
		return $this->tipoDiseniador;
	}
}