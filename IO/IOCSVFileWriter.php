<?php

require_once 'IOFileWriter.php';

/**
 * class IOCSVFileWriter
 * 
 */
class IOCSVFileWriter extends IOFileWriter {

    public function __construct($handle) {
        throw new IONotImplementedYetException();
        parent::__construct($handle);
    }

}

?>
