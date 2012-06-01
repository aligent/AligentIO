<?php

require_once 'IOFileIterator.php';

class IOFixedWidthFileIterator extends IOFileIterator {
    
    public function __construct($handle, array $fieldWidths, $endOfLineSeparator = PHP_EOL) {
        throw new IONotImplementedYetException();
        $parser = new IOFixedWidthFileParser($handle);
        parent::__construct($handle, $parser);
    }
    
}