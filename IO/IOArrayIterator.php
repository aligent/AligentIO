<?php
require_once 'IOIteratorInterface.php';
require_once 'array.php';


/**
 * class IOArrayIterator
 * 
 */
class IOArrayIterator extends IOIteratorInterface
            implements IOIteratorInterface
{

    /** Aggregations: */

    /** Compositions: */

     /*** Attributes: ***/


    /**
     * 
     *
     * @param array array 

     * @return void
     * @access public
     */
    public function __construct( $array ) {
    } // end of member function __construct



    /**
     * 
     *
     * @param IOFieldProperties[] fieldProperties An array of IOFieldProperties.
If an array is provided, then all fields read will be expected to conform to the
requirements specified in the properties.
If NULL (default behaviour) then each row will return whatever fields are found
without any validation.

     * @param boolean hasHeaderRow Whether or not the file has a header row.
If True, The header will be validated to ensure that the labels in the header
field match the labels in fieldProperties.

     * @return void
     * @access public
     */
    public function initialize( $fieldProperties = NULL,  $hasHeaderRow = FALSE ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function initialize

    /**
     * 
     *
     * @return void
     * @access public
     */
    public function getException( ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function getException

    /**
     * 
     *
     * @return boolean
     * @access public
     */
    public function isHeaderMatch( ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function isHeaderMatch



} // end of IOArrayIterator
?>
