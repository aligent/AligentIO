<?php

require_once 'IOFileIterator.php';
require_once 'IOLineFileParser.php';

/**
 * @author luke
 */
class IOLineFileIterator extends IOFileIterator {
    
    public function __construct($handle) {
        $parser = new IOLineFileParser($handle);
        parent::__construct($handle, $parser);
    }
    
}
