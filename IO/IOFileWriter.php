<?php

require_once 'IOWriterInterface.php';

/**
 * class IoFileWriter
 * 
 */
abstract class IOFileWriter implements IOWriterInterface {

    /**
     *
     * @var resource
     */
    protected $handle = NULL;
    private $fieldProperties = array();
    protected $truncateFields = FALSE;
    protected $fieldWidths = NULL;
    private $initialized = FALSE;

    /**
     * 
     *
     * @param resource $handle 
     */
    public function __construct($handle) {
        $this->handle = $handle;
    }

    /**
     * 
     *
     * @param array     $fieldProperties
      Array(
      'name' => '', // The name to use as an index for any returned array of fields.
      'label' => '', // The Label used to validate the file headers.
      'fieldWidth' => NULL,
      'readProcessor' => NULL, // callable. Any type of callback than can be supplied as the $callback parameter of call_user_func. Must accept a single string argument (the field value to be procesed) and return either a string (the processed field value) or FALSE. A FALSE return value is used to indicate that validation has failed, and a subsequent ValidationException will be thrown.
      'writeProcessor' => NULL, // as per readProcessor.
      'allowTruncate' => FALSE,
      )
     * @param boolean   $outputHeaderRow    Whether or not to output a header 
     *                                      row.The header row will be written
     *                                      immediately. Headers are taken from
     *                                      the fieldProperty label fields. No
     *                                      validation or formatting will be 
     *                                      done on headers, and they will be
     *                                      silently truncated to fit within the
     *                                      field width.
     * @param boolean   $truncateFields     Whether or not to allow field truncation
     */
    public function initialize($fieldProperties = NULL, $outputHeaderRow = FALSE, $truncateFields = FALSE) {
        if ($this->initialized) {
            throw new IOObjectAlreadyInitializedException(
                    sprintf('%s already initialized in %s.', __CLASS__, __METHOD__)
            );
        }
        $this->initialized = TRUE;
        if (is_null($fieldProperties)) {
            $fieldProperties = array();
        }
        $this->fieldProperties = $fieldProperties;
        // Note: headers are built regardless of whether they are needed. I need
        // to loop through the array anyway to get the fieldwidths.
        $headers = array();
        $this->fieldWidths = array();
        $numericalIndex = 0;
        foreach ($fieldProperties as $fieldProperty) {
            if (!isset($fieldProperty['fieldWidth'])) {
                throw new IOIllegalParameterException(
                        sprintf('fieldWidth must be set in fieldProperties for each field of a %s in %s', __CLASS__, __METHOD__)
                );
            }
            $this->fieldWidths[] = $fieldProperty['fieldWidth'];
            $label = isset($fieldProperty['label']) ? $fieldProperty['label'] : $numericalIndex;
            $numericalIndex++;
            $headers[] = $label;
        }
        if ($outputHeaderRow) {
            $this->truncateFields = TRUE; // Temporarily truncate fields for header output
            $this->_write($headers); // Do not format or validate headers.
        }
        $this->truncateFields = $truncateFields;
    }

    /**
     * 
     *
     * @param array data The array of data to be written
     * @return int The number of bytes written.
     * @throws IOTooFewFieldsException
     * @throws IOTooManyFieldsException
     * @throws IOIllegalParameterException
     * @throws IOValidationErrorException 
     */
    public function write(array $data) {
        $this->initialized = TRUE;
        return $this->_write(IO::_processFields($data, $this->fieldProperties, 'writeProcessor'));
    }

    /**
     * @param array data The array of sanitized data to be written
     * @return int The number of bytes written.
     */
    protected abstract function _write(array $data);
    
}