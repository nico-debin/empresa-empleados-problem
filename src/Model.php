<?php

/** This class encapsulates the behaviour that any Model should have. */
abstract class Model {
	
	public function __constructor() {
		// Empty constructor
	}

	/** 
	  * Creates a model and assigns its properties from the $values array
	  * @param $values array 
	  */
	public static function withData($values) {
		$instance = new static();
		$instance->fill($values);
		return $instance;
	}

	/**
	  * Fills the model using $values, validating if the properties exists.
	  * Also, it checks if the current class has a method named set{Fieldname}. If it does, 
	  * it is used to assign the corresponding value.
	  */ 
	protected function fill($values) {
		foreach($values as $field => $value) {

			$className  = get_called_class();
			$methodName = "set".ucwords($field);

			if(method_exists($className, $methodName )) {
				$this->{$methodName}($value);
			} else {
				if(property_exists($className, $field)) {
					$this->{$field} = $value;
				} else {
					throw new InvalidClassPropertyException("Unknown property '$className::$field'");
				}
			} 
		}
	}
}