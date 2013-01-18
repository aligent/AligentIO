<?php

require_once 'IO.php';
require_once 'IOFileWriter.php';

/**
 * @author luke
 */
class IOLineFileWriter extends IOFileWriter {

    protected function _write(array $data, IOFieldProcessor $fieldProcessor) {
        return fwrite($this->handle, implode(PHP_EOL, $data));
    }
    
}

