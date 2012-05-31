<?php
require_once 'array.php';
require_once 'boolean.php';


/**
 * class IOWriterInterface
 * 
 */
interface IOWriterInterface
{

    /** Aggregations: */

    /** Compositions: */

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
    public function initialize( $fieldProperties_ = NULL,  $outputHeaderRow = FALSE );

    /**
     * @return int The number of bytes written.
     *
     * @param array data The array of data to be written

     * @return void
     * @access public
     */
    public function write( $data );



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



} // end of IOWriterInterface
?>
