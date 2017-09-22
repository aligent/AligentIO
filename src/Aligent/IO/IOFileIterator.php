<?php
namespace Aligent\IO;

use Aligent\IO\Exception\IOObjectAlreadyInitializedException;
use Aligent\IO\Exception\IOException;
use Aligent\IO\IOIteratorInterface;

/**
 * class IOFileIterator
 * 
 */
abstract class IOFileIterator implements IOIteratorInterface {

    /**
     * @var resource
     */
    private $handle = NULL;

    /**
     * @var IOParserInterface
     */
    private $parser = NULL;

    /**
     * @var int
     */
    private $key = 0;

    /**
     * @var boolean
     */
    private $valid = false;

    /**
     * @var array 
     */
    private $current = NULL;

    /**
     * @var array
     */
    private $formattedCurrent = NULL;

    /**
     * Whether or not this object has already been initialized.
     * This object is implicitly initialized if initialize() is not called.
     * All methods apart from __construct() must set this to TRUE to indicate 
     * this implicit initialization.
     * @var type 
     */
    private $initialized = FALSE;

    /**
     * @var boolean
     */
    private $hasHeaderRow = FALSE;

    /**
     * Contains the read in header row if hasHeaderRow is true, otherwise
     * it remains unset.
     * @var array 
     */
    private $headerRow = array();
    private $exception = NULL;
    
    /**
     * @var IOFieldProcessor
     */
    private $_fieldProcessor = null;

    /**
     * 
     *
     * @param IOParserInterface $parser 
     * @param resource $handle      A valid file pointer to a file successfully
     *                              opened by fopen(), popen(), or fsockopen().
     */
    public function __construct($handle, IOParserInterface $parser) {
        $this->handle = $handle;
        $this->parser = $parser;
        $this->_fieldProcessor = new IOFieldProcessor();
        $this->rewind(); // Note this sets initialezed === TRUE, so set it back to FALSE.
        $this->initialized = FALSE;
    }

    /**
     * NOTE: Calling initialize is optional, however if it is called, it 
     * **MUST** be called befor any other methods.
     *
     * @param array|IOFieldProcessor $fieldProperties
     *                              An array of IOFieldProperties.
     *                              If an array is provided, then all fields 
     *                              read will be expected to conform to the
     *                              requirements specified in the properties.
     *                              If NULL (default behaviour) then each row
     *                              will return whatever fields are found 
     *                              without any validation.
     * @param boolean $hasHeaderRow Whether or not the file has a header row.
     *                              If True, The header will be validated to
     *                              ensure that the labels in the header
     *                              field match the labels in fieldProperties.
     * @return boolean
     */
    public function initialize(array $fieldProperties = NULL, $hasHeaderRow = FALSE) {
        if ($this->initialized) {
            throw new IOObjectAlreadyInitializedException(
                    sprintf('%1$s already initialized. %2$s can only be called once, and MUST be the first method called on %1$s. Note calling %2$s is optional.', __CLASS__, __METHOD__)
            );
        }
        $this->initialized = TRUE;
        if (is_a($fieldProperties, 'IOFieldProcessor')) {
            $this->_fieldProcessor = $fieldProperties;
        } else {
            $this->_fieldProcessor = new IOFieldProcessor((array) $fieldProperties);
        }        $this->hasHeaderRow = $hasHeaderRow;
        $isHeaderMatch = $this->isHeaderMatch();
        $this->rewind();
        return $isHeaderMatch;
    }

    public function getException() {
        $this->initialized = TRUE;
        $exception = $this->exception;
        $this->exception = NULL;
        return $exception;
    }

    /**
     * 
     *
     * @return boolean
     */
    private function isHeaderMatch() {
        $this->initialized = TRUE;
        assert(0 === $this->key()); // MUST be on first line, because this is
        // called from initialize() && initialize
        // can only be called if it's the first method called.

        if (!$this->hasHeaderRow) {
            return TRUE;
        }
        $headerRow = $this->headerRow = $this->current;
        
        return $this->_fieldProcessor->isHeaderMatch($headerRow);
    }

    /**
     * Return the current element
     * @access public
     * @return mixed
     */
    public function current() {
        $this->initialized = TRUE;
        return $this->formattedCurrent;
    }

    /**
     * Return the key of the current element
     * @access public
     * @return scalar
     */
    public function key() {
        $this->initialized = TRUE;
        return $this->key;
    }

    /**
     * Move forward to next element
     * @access public
     */
    public function next() {
        $this->initialized = TRUE;
        $this->exception = NULL;
        try {
            $this->current = $this->parser->readLine();
            $this->formattedCurrent = $this->_fieldProcessor->processFields($this->current, 'readProcessor');
        } catch (IOException $ioEx) {
            $this->current = FALSE;
            $this->formattedCurrent = FALSE;
            $this->exception = $ioEx;
        }
        $this->key++;
        $this->valid = !!$this->current || !feof($this->handle);
    }

    /**
     * Rewind iterator to the first element
     * @access public
     */
    public function rewind() {
        $this->initialized = TRUE;
        $this->exception = NULL;
        if (rewind($this->handle) === FALSE) {
            throw new \Exception(sprintf('Rewind failed in %s', __METHOD__));
        }
        $this->key = -1;
        $this->next();
        if ($this->hasHeaderRow) {
            // Skip the header row.
            if ($this->valid()) {
                $this->next();
            }
        }
    }

    /**
     * Checks if current position is valid
     * @access public
     * @return boolean
     */
    public function valid() {
        $this->initialized = TRUE;
        return $this->valid;
    }

}