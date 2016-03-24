<?php

include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."autoloader.php";

class EmpleadoTest extends PHPUnit_Framework_TestCase {

	public static function getDummyProgramador() {
		return Programador::withData(['id' 			=> 131, 
									  'firstName' 	=> 'Nicolas', 
									  'lastName' 	=> 'De Bin', 
									  'birthDate' 	=> '1988-06-27', 
									  'language' 	=> Languages::PHP
									 ]);
	}

	public static function getDummyDiseniador() {
		return Diseniador::withData(['id' 				=> 131, 
									 'firstName' 		=> 'Nicolas', 
									 'lastName' 		=> 'De Bin', 
									 'birthDate' 		=> '1988-06-27', 
									 'tipoDiseniador' 	=> TipoDiseniador::WEB
									]);
	}

	public static function generateRandomEmpleado() {
		$names = ['Juan', 'Carlos', 'Miguel', 'Angel', 'José', 'Luis', 'Manuel', 'Pablo', 'Ignacio', 'Emanuel', 'Jorge', 'Sebastian', 'Matias'];
		$lastNames = ['Gonzalez', 'Rodriguez', 'Lopez', 'Fernandez', 'García', 'Perez', 'Martinez', 'Sanchez', 'Gomez', 'Diaz', 'Alvarez', 'Sosa'];

		// Random First Name
		$rand_names_index = array_rand($names, 2);
		$firstName = $names[$rand_names_index[0]] . " " . $names[$rand_names_index[1]];

		$data = ['id'			=> intval(mt_rand()), // Random ID
				 'firstName'	=> $firstName,
				 'lastName'		=> $lastNames[array_rand($lastNames)], // Random Last Name
				 'birthDate'	=> date("Y-m-d", mt_rand(1262055,1262055681)) // Random BirthDate
				];

		// Randomly create a Programador or Diseniador
		if(mt_rand(0,1) == 0) {
			$languages = Languages::getAllLanguages();
			$data['language'] = $languages[array_rand($languages)];
			return Programador::withData($data);
		}

		$tipos = TipoDiseniador::getAllTipos();
		$data['tipoDiseniador'] = $tipos[array_rand($tipos)];
		return Diseniador::withData($data);
	}

	public function testEmpleadoID() {
		$empleado = self::getDummyProgramador();
		$this->assertEquals(131, $empleado->getId());
	}

	public function testEmpleadoEdad() {
		$empleado = self::getDummyProgramador();
		$this->assertEquals(27, $empleado->getEdad());
	}

	public function testProgramadorLanguage() {
		$programador = self::getDummyProgramador();
		$this->assertEquals(Languages::PHP, $programador->getLanguage());
	}

	public function testDiseniadorTipo() {
		$diseniador = self::getDummyDiseniador();
		$this->assertEquals(TipoDiseniador::WEB, $diseniador->getTipoDiseniador());
	}

	public function testEmpleadoShouldFailInvalidBirthDate() {
		$this->setExpectedException('InvalidFormatException');
		Programador::withData(['birthDate' => '01/01/2015']);
	}

	public function testProgramadorShouldFailInvalidLanguage() {
		$this->setExpectedException('InvalidValueException');
		Programador::withData(['language' => "Wrong Language"]);
	}

	public function testDiseniadorShouldFailInvalidTipo() {
		$this->setExpectedException('InvalidValueException');
		Diseniador::withData(['tipoDiseniador' => "Wrong Type"]);
	}

	public function testProgramadorWrongAttributes() {
		$this->setExpectedException('InvalidClassPropertyException');
		Diseniador::withData(['wrongAttr' => "blah blah"]);
	}

}