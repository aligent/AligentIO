<?php
namespace Aligent\IO\Exception;

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