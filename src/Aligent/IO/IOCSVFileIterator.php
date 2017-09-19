<?php
namespace Aligent\IO;

use Aligent\IO\IOFileIterator;
use Aligent\IO\IOCSVFileParser;

class IOCSVFileIterator extends IOFileIterator {
    
    public function __construct($handle, $length = 0, $delimiter = ',', $enclosure = '"', $escape = '\\') {
        $parser = new IOCSVFileParser($handle, $length, $delimiter, $enclosure, $escape);
        parent::__construct($handle, $parser);
    }
    
}