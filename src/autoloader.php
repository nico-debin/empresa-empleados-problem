<?php

spl_autoload_register(function($className){
	$className = str_replace("\\", "/", $className);
	
	if(strpos($className, 'Exception') === false) {
		$class = __DIR__."/{$className}.php";
	} else {
		$class = __DIR__."/exceptions/{$className}.php";
	}

	include_once($class);
});