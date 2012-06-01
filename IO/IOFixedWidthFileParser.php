<?php

require_once 'IOParserInterface.php';

/**
 * class IOFixedWidthFileParser
 * 
 */
class IOFixedWidthFileParser implements IOParserInterface {

    public function __construct($handle) {
        throw new IONotImplementedYetException();
    }

    public function readLine() {
        throw new IONotImplementedYetException();
    }

}