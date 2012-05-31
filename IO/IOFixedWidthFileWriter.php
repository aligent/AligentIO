<?php

require_once 'IoFileWriter.php';

/**
 * class IOFixedWidthFileWriter
 * 
 */
class IOFixedWidthFileWriter extends IOFileWriter {
    
    
    public function __construct($handle) {
        throw new IONotImplementedYetException();
        parent::__construct($handle);
    }
}