<?php
namespace Aligent\IO;

use Aligent\IO\Exception\IOTooFewFieldsException;
use Aligent\IO\Exception\IOTooManyFieldsException;
use Aligent\IO\Exception\IOIllegalParameterException;
use Aligent\IO\Exception\IOValidationErrorException;

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
    
    /**
     * @param array $fieldProperties an array of field properties in the following
     * format:
      Array(
        'name' => '', // The name to use as an index for any returned array of fields.
        'label' => '', // The Label used to validate the file headers.
        'fieldWidth' => NULL,
        'readProcessor' => NULL, // callable. Any type of callback than can be supplied as the $callback parameter of call_user_func. Must accept a single string argument (the field value to be procesed) and return either a string (the processed field value) or FALSE. A FALSE return value is used to indicate that validation has failed, and a subsequent ValidationException will be thrown.
        'writeProcessor' => NULL, // as per readProcessor.
        'allowTruncate' => FALSE,
      )
     * 
     */
    public function __construct(array $fieldProperties = array()) {
        $this->_fieldProperties = $fieldProperties;
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
