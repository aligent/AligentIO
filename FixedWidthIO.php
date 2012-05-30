<?php

require_once 'FixedWidthIOExceptions.php';

class FixedWidthIO {

    // array str_getcsv ( string $input [, string $delimiter = ',' [, string $enclosure = '"' [, string $escape = '\\' ]]] )
    /**
     * Parse a fixed width string into an array.
     * 
     * Parses a string input for fields in fixed width format and returns an
     * array containing the fields read.
     * The indexes of the $fieldWidths array will be used for the indexes of the
     * returned array.
     * 
     * Assumptions:
     * Field values are rtrimmed.
     * 
     * @param string $input       The string to parse.
     * @param int[]  $fieldWidths An array of ints. The keys of the array will
     *                            be used for the keys of the returned array.
     *                            (i.e. field names)
     * @return string[]           An array of strings indexed by the keys of 
     *                            $fieldWidths containing the (rtrimmed) string
     *                            values of the fields.
     * @throws FixedWidthIOIllegalParameterException
     * @throws FixedWidthIOInputTooShortException
     * @throws FixedWidthIOInputTooLongException 
     */
    public static function str_getfw($input, array $fieldWidths) {
        $input = (string) $input;
        $inputLength = strlen($input);
        $array = array();
        $offset = 0;
        foreach ($fieldWidths as $key => $fieldWidth) {
            if (!is_int($fieldWidth)) {
                throw new FixedWidthIOIllegalParameterException(
                        sprintf('fieldWidths must be and array of ints in %s',
                                __METHOD__)
                );
            }
            $fieldWidth = (int) $fieldWidth;
            if ($offset + $fieldWidth > $inputLength) {
                throw new FixedWidthIOInputTooShortException(
                        sprintf('Sum of fieldWidths exceeded the length of the input string in %s',
                                __METHOD__)
                );
            }
            $array[$key] = rtrim(substr($input, $offset, $fieldWidth));
            $offset += $fieldWidth;
        }
        if ($offset < $inputLength) {
            throw new FixedWidthIOInputTooLongException(
                    sprintf('The input string was longer than the sum of fieldWidths in %s',
                            __METHOD__)
            );
        }
        return $array;
    }

}