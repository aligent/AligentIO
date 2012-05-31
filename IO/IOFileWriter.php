<?php

require_once 'IOWriterInterface.php';

/**
 * class IoFileWriter
 * 
 */
abstract class IOFileWriter extends IOWriterInterface implements IOWriterInterface {

    /**
     * 
     *
     * @param resource $handle 
     */
    public function __construct($handle) {
        throw new IONotImplementedYetException();
    }

    /**
     * 
     *
     * @param array     $fieldProperties

     * @param boolean   $outputHeaderRow    Whether or not to output a header 
     *                                      row.The header row will be written
     *                                      immediately. Headers are taken from
     *                                      the fieldProperty label fields. No
     *                                      validation or formatting will be 
     *                                      done on headers, and they will be
     *                                      silently truncated to fit within the
     *                                      field width.
     */
    public function initialize(array $fieldProperties = NULL, $outputHeaderRow = FALSE) {
        throw new IONotImplementedYetException();
    }

    /**
     * 
     *
     * @param array data The array of data to be written
     * @return int The number of bytes written.
     */
    public function write(array $data) {
        throw new IONotImplementedYetException();
    }

}