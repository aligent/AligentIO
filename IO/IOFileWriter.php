<?php
require_once 'IOWriterInterface.php';
require_once 'IOWriterInterface.php';
require_once 'resource.php';


/**
 * class IoFileWriter
 * 
 */
abstract class IOFileWriter extends IOWriterInterface    //WARNING: PHP5 does not support multiple inheritance but there is more than 1 superclass defined in your UML model!
            implements IOWriterInterface
{

    /** Aggregations: */

    /** Compositions: */

     /*** Attributes: ***/


    /**
     * 
     *
     * @param resource handle 

     * @return void
     * @access public
     */
    public function __construct( $handle ) {
    } // end of member function __construct



    /**
     * 
     *
     * @param array fieldProperties_ 

     * @param boolean outputHeaderRow Whether or not to output a header row.
The header row will be written immediately.
Headers are taken from the fieldProperty label fields. No validation or
formatting will be done on headers, and they will be silently truncated to fit
within the field width.

     * @return void
     * @access public
     */
    public function initialize( $fieldProperties_ = NULL,  $outputHeaderRow = FALSE ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function initialize

    /**
     * @return int The number of bytes written.
     *
     * @param array data The array of data to be written

     * @return void
     * @access public
     */
    public function write( $data ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function write



} // end of IoFileWriter
?>
