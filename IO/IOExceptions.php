<?php

/**
 * A generic exception for the IO package 
 */
class IOException extends Exception {}

/**
 * Thrown when an illegal parameter is passed to a function in the IO
 * package. 
 */
class IOIllegalParameterException extends IOException {}

/**
 * Thrown when the sum of the fieldWidths exceeds the length of the input string 
 */
class IOInputTooShortException extends IOException {}

/**
 * Thrown when the input string is longer than the sum of fieldWidths 
 */
class IOInputTooLongException extends IOException {}

/**
 * Thrown when a field exceeds its fieldWidth 
 */
class IOFieldOverflowException extends IOException {}

/**
 * Thrown when there are more fields than fieldWidths 
 */
class IOTooManyFieldsException extends IOException {}

/**
 * Thrown when there are less fields than fieldWidths 
 */
class IOTooFewFieldsException extends IOException {}

/**
 * Thrown when attempting to write line which contains an end of line separator character. 
 */
class IOEndOfLineSeparatorContainedInLineException extends IOException {}

/**
 * Thrown when attempting to use unimplemented functionality
 */
class IONotImplementedYetException extends IOException {}

/**
 * Thrown when attempting to initialize an object that has already been initialized. 
 */
class IOObjectAlreadyInitializedException extends IOException {}

/**
 * Thrown when a validation exception occurs 
 */
class IOValidationErrorException extends IOException {
    
    private $fieldProperties = array();
    
    private $fieldValue = NULL;
    
    public function __construct($message = '', $code = 0, $previous = NULL, $fieldProperties = NULL, $fieldValue = NULL) {
        $this->fieldProperties = $fieldProperties;
        $this->fieldValue = $fieldValue;
        parent::__construct($message, $code, $previous);
    }
    
    public function getFieldProperties() {
        return $this->fieldProperties;
    }
    
}