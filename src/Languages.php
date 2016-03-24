<?php

class Languages {
	const PHP = 'PHP';
	const PYTHON = 'PYTHON';
	const PUNTO_NET = '.NET';

	public static function getAllLanguages() {
		return (new ReflectionClass(get_class()))->getConstants();
	}

	public static function isValidLanguage($lang) {
		$allLanguages = self::getAllLanguages();
		return in_array($lang, $allLanguages);
	}
}