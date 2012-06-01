<?php

require_once 'IOFileWriter.php';

/**
 * class IOFixedWidthFileWriter
 * 
 */
class IOFixedWidthFileWriter extends IOFileWriter {

    public function write(array $data) {
        parent::write($data);
        return IO::fputfw($this->handle, $data, $this->fieldWidths, PHP_EOL, $this->truncateFields);
    }

}