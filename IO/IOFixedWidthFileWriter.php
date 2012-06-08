<?php

require_once 'IOFileWriter.php';

/**
 * class IOFixedWidthFileWriter
 * 
 */
class IOFixedWidthFileWriter extends IOFileWriter {

    protected function _write(array $data) {
        return IO::fputfw($this->handle, $data, $this->_fieldProcessor->getFieldWidths(), PHP_EOL, $this->truncateFields);
    }

}