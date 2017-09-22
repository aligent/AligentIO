<?php
namespace Aligent\IO;

use Aligent\IO\IOParserInterface;

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