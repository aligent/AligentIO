<?php
namespace Aligent\IO;

use Aligent\IO\IOLineFileParser;
use Aligent\IO\IOFileIterator;

/**
 * @author luke
 */
class IOLineFileIterator extends IOFileIterator {
    
    public function __construct($handle) {
        $parser = new IOLineFileParser($handle);
        parent::__construct($handle, $parser);
    }
    
}
