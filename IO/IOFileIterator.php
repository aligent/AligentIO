<?php

require_once 'IOIteratorInterface.php';

/**
 * class IOFileIterator
 * 
 */
abstract class IOFileIterator extends IOIteratorInterface implements IOIteratorInterface {

    /**
     * 
     *
     * @param resource $handle      A valid file pointer to a file successfully
     *                              opened by fopen(), popen(), or fsockopen().
     */
    public function __construct($handle) {
        throw new IONotImplementedYetException();
    }

    /**
     * 
     *
     * @param IOFieldProperties[] fieldProperties An array of IOFieldProperties.
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
     */
    public function initialize(array $fieldProperties = NULL, $hasHeaderRow = FALSE) {
        throw new IONotImplementedYetException();
    }

    /**
     * 
     *
     */
    public function getException() {
        throw new IONotImplementedYetException();
    }

    /**
     * 
     *
     * @return boolean
     */
    public function isHeaderMatch() {
        throw new IONotImplementedYetException();
    }

    public abstract function current();

    public function key() {
        throw new IONotImplementedYetException();
    }

    public function next() {
        throw new IONotImplementedYetException();
    }

    public function rewind() {
        throw new IONotImplementedYetException();
    }

    public function valid() {
        throw new IONotImplementedYetException();
    }

}
