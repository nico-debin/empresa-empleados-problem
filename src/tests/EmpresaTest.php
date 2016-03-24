<?php

include_once __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."autoloader.php";

class EmpresaTest extends PHPUnit_Framework_TestCase {

	public static function getDummyEmpresa() {
		return Empresa::withdata(['id' 		=> 5,
								  'name' 	=> 'Coca Cola'
								 ]);
	}

	public static function getDummyProgramador() {
		return EmpleadoTest::getDummyProgramador();
	}

	public function testEmpresaID() {
		$empresa = $this->getDummyEmpresa();
		$this->assertEquals(5, $empresa->getId());
	}

	public function testAmountEmpleadosExpectedZero() {
		$empresa = $this->getDummyEmpresa();
		$amount = count($empresa->getEmpleados());
		$this->assertEquals(0, $amount);
	}

	public function testAmountEmpleados() {
		$empresa = $this->getDummyEmpresa();

		for($i=0; $i<10; $i++) {
			$empleado = EmpleadoTest::generateRandomEmpleado();
			$empresa->addEmpleado($empleado);
		}

		$amount = count($empresa->getEmpleados());
		$this->assertEquals(10, $amount);
	}

	public function testRepeatedEmpleado() {
		$empresa = $this->getDummyEmpresa();

		// I'll try to reinsert firstEmpleado at the end
		$firstEmpleado = EmpleadoTest::generateRandomEmpleado();
		$empresa->addEmpleado($firstEmpleado);

		// Adding some random empleados
		for($i=0; $i<5; $i++) {
			$empleado = EmpleadoTest::generateRandomEmpleado();
			$empresa->addEmpleado($empleado);
		}

		$amount_initial = count($empresa->getEmpleados());
		$empresa->addEmpleado($firstEmpleado); // This Empleado is already added
		$amount_final = count($empresa->getEmpleados());

		$this->assertEquals($amount_initial, $amount_final);
	}

	public function testFindEmpleado() {
		$empresa = $this->getDummyEmpresa();
		$randomIndex = mt_rand(0, 20);
		$rememberEmpleado = null;

		// Load empleados to empresa
		for($i=0; $i<20; $i++) {
			$empleado = EmpleadoTest::generateRandomEmpleado();

			// This will happen only once
			if($i == $randomIndex) {
				$rememberEmpleado = $empleado;
			}

			$empresa->addEmpleado($empleado);
		}

		// Just checking
		$this->assertNotNull($rememberEmpleado);

		$empleadoFound = $empresa->getEmpleado($rememberEmpleado->getId());

		// Checks if an Empleado is found
		$this->assertNotNull($empleadoFound);

		// Properties comparation
		$this->assertEquals($rememberEmpleado->getId(), $empleadoFound->getId());
		$this->assertEquals($rememberEmpleado->getFirstName(), $empleadoFound->getFirstName());
		$this->assertEquals($rememberEmpleado->getLastName(), $empleadoFound->getLastName());
		$this->assertEquals($rememberEmpleado->getBirthDate(), $empleadoFound->getBirthDate());
		$this->assertEquals($rememberEmpleado->getEdad(), $empleadoFound->getEdad());

		// Class comparation
		$this->assertEquals(get_class($rememberEmpleado), get_class($empleadoFound));

		if(get_class($empleadoFound) == 'Programador') {
			$this->assertEquals($rememberEmpleado->getLanguage(), $empleadoFound->getLanguage());
		} elseif(get_class($empleadoFound) == 'Diseniador') {
			$this->assertEquals($rememberEmpleado->getTipoDiseniador(), $empleadoFound->getTipoDiseniador());
		}
	}

	public function testAverageAge() {
		$empresa = $this->getDummyEmpresa();
		$year = intval(date('Y')) - 20;

		for($i=0; $i<5; $i++) {
			$year -= 2;
			$birthDate = "$year-01-01";

			$empleado = EmpleadoTest::generateRandomEmpleado();
			$empleado->setBirthDate($birthDate);

			$empresa->addEmpleado($empleado);
		}

		$this->assertEquals(26, $empresa->getAverageAge());
	}
}