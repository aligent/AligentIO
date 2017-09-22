<?php

namespace Aligent\IO;

use Aligent\IO\IOFileWriter;

/**
 * class IOFixedWidthFileWriter
 * 
 */
class IOFixedWidthFileWriter extends IOFileWriter {

    protected function _write(array $data, IOFieldProcessor $fieldProcessor) {
        return IO::fputfw($this->handle, $data, $fieldProcessor->getFieldWidths(), PHP_EOL, $this->truncateFields);
    }

}