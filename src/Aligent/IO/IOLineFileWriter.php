<?php
namespace Aligent\IO;

use Aligent\IO\IOFileWriter;

/**
 * @author luke
 */
class IOLineFileWriter extends IOFileWriter {

    protected function _write(array $data, IOFieldProcessor $fieldProcessor) {
        return fwrite($this->handle, implode(PHP_EOL, $data));
    }
    
}

