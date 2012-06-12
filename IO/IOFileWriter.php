<?php

require_once 'IOWriterInterface.php';
require_once 'IOFieldProcessor.php';

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
    protected $truncateFields = FALSE;
    protected $fieldWidths = NULL;
    private $initialized = FALSE;
    private $linesWritten = 0;
    
    /**
     * @var IOFieldProcessor
     */
    protected $_fieldProcessor = NULL;

    /**
     * 
     *
     * @param resource $handle 
     */
    public function __construct($handle) {
        $this->handle = $handle;
        $this->_fieldProcessor = new IOFieldProcessor();
    }

    /**
     * 
     *
     * @param array|IOFieldProcessor $fieldProperties
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
        if (is_a($fieldProperties, 'IOFieldProcessor')) {
            $this->_fieldProcessor = $fieldProperties;
        } else {
            $this->_fieldProcessor = new IOFieldProcessor((array) $fieldProperties);
        }
        if ($outputHeaderRow) {
            $this->truncateFields = TRUE; // Temporarily truncate fields for header output
            $this->_write($this->_fieldProcessor->getHeaders()); // Do not format or validate headers.
        }
        $this->truncateFields = $truncateFields;
    }

    /**
     * 
     *
     * @param array data The array of data to be written
     * @param IOFieldProcessor $fieldProcessor  An optional IOFieldProcessor to
     *                                          use for THIS LINE ONLY.
     *                                          If $fieldProcessor is supplied, 
     *                                          then it will override the 
     *                                          $fieldProperties supplied to 
     *                                          initialize().
     *                                          If $fieldProcessor is NULL (default)
     *                                          then the $fieldProperties supplied 
     *                                          to initialize() will be used.
     * @return int The number of bytes written.
     * @throws IOTooFewFieldsException
     * @throws IOTooManyFieldsException
     * @throws IOIllegalParameterException
     * @throws IOValidationErrorException 
     */
    public function write(array $data, IOFieldProcessor $fieldProcessor = NULL) {
        $this->initialized = TRUE;
        if (is_null($fieldProcessor)) {
            $fieldProcessor = $this->_fieldProcessor;
        }
        return $this->_write($fieldProcessor->processFields($data, 'writeProcessor'), $fieldProcessor);
    }
    
    public function setLinesWritten(int $iLinesWritten){
        $this->linesWritten += $iLinesWritten;
    }
    
    public function getLinesWritten(){
        return $this->linesWritten;
    }
    
    public function incLinesWritten(){
        $this->linesWritten ++;
    }

    /**
     * @param array data The array of sanitized data to be written
     * @return int The number of bytes written.
     */
    protected abstract function _write(array $data, IOFieldProcessor $fieldProcessor);
    
}