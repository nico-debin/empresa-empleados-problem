<?php

class TipoDiseniador {
	const GRAFICO = 'GRÁFICO';
	const WEB = 'WEB';

	public static function getAllTipos() {
		return (new ReflectionClass(get_class()))->getConstants();
	}

	public static function isValidTipo($tipo) {
		$allTipos = self::getAllTipos();
		return in_array($tipo, $allTipos);
	}
}