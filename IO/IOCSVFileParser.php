<?php

require_once 'IOFileParserInterface.php';

/**
 * class IOCSVFileIterator
 * 
 */
class IOCSVFileParser implements IOFileParserInterface {

    /**
     *
     * @var resource
     */
    private $handle = NULL;

    /**
     *
     * @var int
     */
    private $length = 0;

    /**
     *
     * @var char
     */
    private $delimiter = '';

    /**
     *
     * @var char
     */
    private $enclosure = '';

    /**
     *
     * @var char
     */
    private $escape = '';

    /**
     *
     * @param resource  $handle
     * @param int       $length
     * @param char      $delimiter
     * @param char      $enclosure
     * @param char      $escape
     */
    public function __construct($handle, $length = 0, $delimiter = ',', $enclosure = '"', $escape = '\\') {
        $this->handle = $handle;
        $this->length = $length;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape = $escape;
    }

    /**
     *
     * @return array|NULL|FALSE
     */
    public function readLine() {
        return fgetcsv($this->handle, $this->length, $this->delimiter, $this->enclosure, $this->escape);
    }

}