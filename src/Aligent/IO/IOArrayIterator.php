<?php
namespace Aligent\IO;

use Aligent\IO\IOIteratorInterace;

/**
 * class IOArrayIterator
 * 
 */
class IOArrayIterator implements IOIteratorInterface {

    private $_data = array();
    private $_error;

    
    /**
     * @param array $aData The data we'll iterate through 
     */
    public function __construct($aData) {
        if (is_array($aData)) {
            $this->_data = $aData;
        }
    }

    /**
     * 
     *
     * @param IOFieldProperties[] fieldProperties An array of IOFieldProperties.
     *                                  If an array is provided, then all fields
     *                                  read will be expected to conform to the
     *                                  requirements specified in the properties.
     *                                  If NULL (default behaviour) then each 
     *                                  row will return whatever fields are 
     *                                  found without any validation.
     * @param boolean hasHeaderRow      Whether or not the file has a header row.
     *                                  If True, The header will be validated to 
     *                                  ensure that the labels in the header
     *                                  field match the labels in fieldProperties.
     */
    public function initialize(array $fieldProperties = NULL, $hasHeaderRow = FALSE) {
        throw new IONotImplementedYetException();
    }

    
    /**
     * 
     * @return Exception                Any kind of Exception that was thrown
     *                                  that caused current() to return false.
     *                                  @see IOException
     */
    public function getException() {
        return $this->_error;
    }

    /**
     * 
     *
     * @return boolean
     */
    public function isHeaderMatch() {
        throw new IONotImplementedYetException();
    }

    /**
     * Implementing a simple array iterator for testing. 
     */
    public function current() {
        $var = current($this->_data);
        if (! is_array($var)) {
            $this->_error = new Exception($var);
            return false;
        }
        return $var;
    }

    /**
     * Implementing a simple array iterator for testing. 
     */
    public function key() {
        $var = key($this->_data);
        return $var;
    }


    /**
     * Implementing a simple array iterator for testing. 
     */
    public function next() {
        $var = next($this->_data);
        if (! is_array($var)) {
            $this->_error = new Exception($var);
            return false;
        }
        return $var;
    }

    
    /**
     * Implementing a simple array iterator for testing. 
     */
    public function rewind() {
        reset($this->_data);
    }

    
    /**
     * Implementing a simple array iterator for testing. 
     */
    public function valid() {
        $key = key($this->_data);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

}

