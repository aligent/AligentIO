<?php

require_once 'IOFileParserInterface.php';

/**
 * class IOFixedWidthFileIterator
 * 
 */
class IOFixedWidthFileIterator implements IOFileParserInterface {

    public function __construct($handle) {
        throw new IONotImplementedYetException();
        parent::__construct($handle);
    }

    public function readLine() {
        throw new IONotImplementedYetException();
    }

}