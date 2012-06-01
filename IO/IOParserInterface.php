<?php

interface IOParserInterface {
    
    /**
     * Reads a line from and returns an array
     * May throw any Exception
     * @return array
     * @throws Exception|IOException 
     */
    public function readLine();
    
}