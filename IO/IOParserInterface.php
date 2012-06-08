<?php

require_once 'IOExceptions.php';

interface IOParserInterface {
    
    /**
     * Reads a line from a file and returns an array
     * May throw any Exception
     * @return array
     * @throws Exception|IOException 
     */
    public function readLine();
    
}