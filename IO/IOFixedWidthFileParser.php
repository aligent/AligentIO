<?php

require_once 'IOFileParserInterface.php';

/**
 * class IOFixedWidthFileParser
 * 
 */
class IOFixedWidthFileParser implements IOFileParserInterface {

    public function __construct($handle) {
        throw new IONotImplementedYetException();
    }

    public function readLine() {
        throw new IONotImplementedYetException();
    }

}