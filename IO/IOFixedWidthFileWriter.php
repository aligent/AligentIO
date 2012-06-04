<?php

require_once 'IOFileWriter.php';

/**
 * class IOFixedWidthFileWriter
 * 
 */
class IOFixedWidthFileWriter extends IOFileWriter {

    protected function _write(array $data) {
        return IO::fputfw($this->handle, $data, $this->fieldWidths, PHP_EOL, $this->truncateFields);
    }

}