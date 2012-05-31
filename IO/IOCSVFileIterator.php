<?php

require_once 'IOFileIterator.php';

/**
 * class IOCSVFileIterator
 * 
 */
class IOCSVFileIterator extends IOFileIterator {

    public function __construct($handle) {
        throw new IONotImplementedYetException();
        parent::__construct($handle);
    }

    public function current() {
        throw new IONotImplementedYetException();
    }

}