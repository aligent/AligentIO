<?php
namespace Aligent\IO;

use Aligent\IO\IOFileWriter;

/**
 * class IOCSVFileWriter
 * 
 */
class IOCSVFileWriter extends IOFileWriter {

    protected function _write(array $data, IOFieldProcessor $fieldProcessor) {
        throw new IONotImplementedYetException();
    }

}
