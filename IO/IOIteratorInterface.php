<?php
require_once 'Iterator.php';
require_once 'IOFieldProperties[].php';
require_once 'boolean.php';


/**
 * class IOIteratorInterface
 * 
 */
interface IOIteratorInterface
{

    /** Aggregations: */

    /** Compositions: */

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
    public function initialize( $fieldProperties = NULL,  $hasHeaderRow = FALSE );

    /**
     * 
     *
     * @return void
     * @access public
     */
    public function getException( );

    /**
     * 
     *
     * @return boolean
     * @access public
     */
    public function isHeaderMatch( );



    /**
     * 
     *
     * @return void
     * @access public
     */
    public function current( ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function current

    /**
     * 
     *
     * @return void
     * @access public
     */
    public function key( ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function key

    /**
     * 
     *
     * @return void
     * @access public
     */
    public function next( ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function next

    /**
     * 
     *
     * @return void
     * @access public
     */
    public function rewind( ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function rewind

    /**
     * 
     *
     * @return bool
     * @access public
     */
    public function valid( ) {
        trigger_error("Implement " . __FUNCTION__);
    } // end of member function valid

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



} // end of IOIteratorInterface
?>
