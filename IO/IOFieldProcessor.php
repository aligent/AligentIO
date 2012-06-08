<?php
require_once 'IOExceptions.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IOFieldProcessor
 *
 * @author luke
 */
class IOFieldProcessor {
    
    private $_fieldProperties = array();
    private $_headers = NULL;
    private $_fieldWidths = NULL;
    
    private static $instance = 0;
    
    public function __construct(array $fieldProperties = array()) {
        $this->_fieldProperties = $fieldProperties;
        $instance = ++static::$instance;
    }
    
    /**
     * Returns an array of header fields
     * @return array    The header fields.
     */
    public function getHeaders() {
        if (is_null($this->_headers)) {
            $this->_calculateFieldWidthsAndHeaders();
        }
        return $this->_headers;
    }
    
    /**
     * Returns an array of field widths
     * @return array    The field widths.
     */
    public function getFieldWidths() {
        if (is_null($this->_fieldWidths)) {
            $this->_calculateFieldWidthsAndHeaders();
        }
        return $this->_fieldWidths;
    }
    
    /**
     * Compares $headerRow with the field properties' labels.
     * Returns TRUE if there were exactly the same number of fields and all the
     * labels match, FALSE otherwise.
     * @param array $headerRow
     * @return boolean 
     */
    public function isHeaderMatch(array $headerRow) {
        $fieldProperties = $this->_fieldProperties;
        if (count($fieldProperties) !== count($headerRow)) {
            return FALSE;
        }
        while (count($fieldProperties) > 0 && count($headerRow) > 0) {
            $fieldProperty = array_shift($fieldProperties);
            $header = array_shift($headerRow);
            if ($fieldProperty['label'] !== $header) {
                return FALSE;
            }
        }
        return TRUE;
    }
    
    /**
     * Used to apply read/write processors to fields.
     * @param array $fields
     * @param string $processorName       'readProcessor' || 'writeProcessor'
     * @return array The processes fields
     * @throws IOTooFewFieldsException
     * @throws IOTooManyFieldsException
     * @throws IOIllegalParameterException
     * @throws IOValidationErrorException 
     */
    public function processFields($fields, $processorName) {
        $instance = static::$instance;
        $fields = (array) $fields;
        $fieldProperties = $this->_fieldProperties;
        if (count($fieldProperties) === 0) {
            return $fields;
        } elseif (count($fields) < count($fieldProperties)) {
            throw new IOTooFewFieldsException(
                    sprintf('There were less fields (%s) than field properties (%s).',count($fields) , count($fieldProperties))
            );
        } if (count($fields) > count($fieldProperties)) {
            throw new IOTooManyFieldsException(
                    sprintf('There were more fields (%s) than field properties (%s)',count($fields) , count($fieldProperties))
            );
        }
        $formattedFields = array();
        $numericIndex = 0;
        while (count($fields) > 0 && count($fieldProperties) > 0) {
            $field = array_shift($fields);
            $fieldProperty = array_shift($fieldProperties);
            $index = isset($fieldProperty['name']) ? $fieldProperty['name'] : $numericIndex;
            if (isset($fieldProperty[$processorName])) {
                $processor = $fieldProperty[$processorName];
                if (!is_callable($processor)) {
                    throw new IOIllegalParameterException(
                            sprintf("%s for field '%s' is not callable", $processorName, $index)
                    );
                }
                $formattedFields[$index] = call_user_func($processor, $field);
                if ($formattedFields[$index] === FALSE) {
                    throw new IOValidationErrorException(
                            'Field validation failed', 0, NULL, $fieldProperty, $field
                    );
                }
            } else {
                $formattedFields[$index] = $field;
            }

            $numericIndex++;
        }

        return $formattedFields;
    }
    
    private function _calculateFieldWidthsAndHeaders() {
        $this->_headers = array();
        $this->_fieldWidths = array();
        $numericalIndex = 0;
        foreach ($this->_fieldProperties as $fieldProperty) {
            if (!isset($fieldProperty['fieldWidth'])) {
                throw new IOIllegalParameterException(
                        sprintf('fieldWidth must be set in fieldProperties for each field of a %s in %s', __CLASS__, __METHOD__)
                );
            }
            $this->_fieldWidths[] = $fieldProperty['fieldWidth'];
            $label = isset($fieldProperty['label']) ? $fieldProperty['label'] : $numericalIndex;
            $numericalIndex++;
            $this->_headers[] = $label;
        }
    }
}

?>
