<?php
namespace Aligent\IO;

use Aligent\IO\IOParserInterface;

/**
 * class IOCSVFileIterator
 * 
 */
class IOCSVFileParser implements IOParserInterface {

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
     * @param resource $handle      A valid file pointer to a file successfully
     *                              opened by fopen(), popen(), or fsockopen().
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