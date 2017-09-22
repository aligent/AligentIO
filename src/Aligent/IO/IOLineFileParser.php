<?php
namespace Aligent\IO;

use Aligent\IO\IOParserInterface;

/**
 *
 * @author luke
 */
class IOLineFileParser implements IOParserInterface {

    protected $_handle = null;


    public function __construct($handle) {
        $this->_handle = $handle;
    }
    
    public function readLine() {
        return fgets($this->_handle);
    }
    
}