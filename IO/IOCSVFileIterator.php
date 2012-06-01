<?php

require_once 'IOFileIterator.php';

class IOCSVFileIterator extends IOFileIterator {
    
    public function __construct($handle, $length = 0, $delimiter = ',', $enclosure = '"', $escape = '\\') {
        $parser = new IOCSVFileParser($handle, $length, $delimiter, $enclosure, $escape);
        parent::__construct($handle, $parser);
    }
    
}