<?php

require_once 'IOParserInterface.php';

/**
 * class IOFixedWidthFileParser
 * 
 */
class IOFixedWidthFileParser implements IOParserInterface {

    /**
     *
     * @param resource $handle      A valid file pointer to a file successfully
     *                              opened by fopen(), popen(), or fsockopen().
     */
    public function __construct($handle) {
        throw new IONotImplementedYetException();
    }

    public function readLine() {
        throw new IONotImplementedYetException();
    }

}