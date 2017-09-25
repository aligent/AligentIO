<?php
namespace Aligent\IO;

use Aligent\IO\IOFileIterator;
use Aligent\IO\IONotImplementedYetException;

class IOFixedWidthFileIterator extends IOFileIterator {
    
    public function __construct($handle, array $fieldWidths, $endOfLineSeparator = PHP_EOL) {
        throw new IONotImplementedYetException();
        $parser = new IOFixedWidthFileParser($handle);
        parent::__construct($handle, $parser);
    }
    
}