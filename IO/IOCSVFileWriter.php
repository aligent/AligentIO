<?php

require_once 'IOFileWriter.php';

/**
 * class IOCSVFileWriter
 * 
 */
class IOCSVFileWriter extends IOFileWriter {

    protected function _write(array $data) {
        throw new IONotImplementedYetException();
    }

}

?>
