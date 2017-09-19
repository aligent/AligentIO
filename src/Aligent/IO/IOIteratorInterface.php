<?php
namespace Aligent\IO;

/**
 * IOIteratorInterface
 * 
 */
interface IOIteratorInterface extends \Iterator {

    /**
     * 
     *
     * @param IOFieldProperties[] $fieldProperties An array of IOFieldProperties.
     *                                  If an array is provided, then all $fields
     *                                  read will be expected to conform to the
     *                                  requirements specified in the properties.
     *                                  If NULL (default behaviour) then each row
     *                                  will return whatever fields are found 
     *                                  without any validation.
     * @param boolean $hasHeaderRow     Whether or not the file has a header row.
     *                                  If True, The header will be validated to
     *                                  ensure that the labels in the header
     *                                  field match the labels in fieldProperties.
     * @return boolean                  Whether or not the supplied header fields
     *                                  matched the label fields of the
     *                                  ioFieldProperties array passed to 
     *                                  initialize().     */
    public function initialize(array $fieldProperties = NULL, $hasHeaderRow = FALSE);

    /**
     * 
     * @return \Exception                Any kind of Exception that was thrown
     *                                  that caused current() to return false.
     *                                  @see IOException
     */
    public function getException();

}