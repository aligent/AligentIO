<?php
namespace Aligent\IO;

use Aligent\IO\Exception\IOEndOfLineSeparatorContainedInLineException;
use Aligent\IO\Exception\IOFieldOverflowException;
use Aligent\IO\Exception\IOIllegalParameterException;
use Aligent\IO\Exception\IOInputTooShortException;
use Aligent\IO\Exception\IOInputTooLongException;
use Aligent\IO\Exception\IONotImplementedYetException;
use Aligent\IO\Exception\IOTooManyFieldsException;
use Aligent\IO\Exception\IOTooFewFieldsException;

class IO {

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
     * Field padding character is a space.
     * 
     * @param string $input       The string to parse.
     * @param int[]  $fieldWidths An array of ints. The keys of the array will
     *                            be used for the keys of the returned array.
     *                            (i.e. field names)
     * @return string[]           An array of strings indexed by the keys of 
     *                            $fieldWidths containing the (rtrimmed) string
     *                            values of the fields.
     * @throws IOIllegalParameterException
     * @throws IOInputTooShortException
     * @throws IOInputTooLongException 
     */
    public static function str_getfw($input, array $fieldWidths) {
        $input = (string) $input;
        $inputLength = strlen($input);
        $array = array();
        $offset = 0;
        foreach ($fieldWidths as $key => $fieldWidth) {
            if (!is_int($fieldWidth) || $fieldWidth < 0) {
                throw new IOIllegalParameterException(
                        sprintf('fieldWidths must be an array of ints in %s', __METHOD__)
                );
            }
            if ($offset + $fieldWidth > $inputLength) {
                throw new IOInputTooShortException(
                        sprintf('Sum of fieldWidths (%d) exceeded the length of the input string (%d) in %s', ($offset + $fieldWidth), $inputLength, __METHOD__)
                );
            }
            $array[$key] = rtrim(substr($input, $offset, $fieldWidth));
            $offset += $fieldWidth;
        }
        if ($offset < $inputLength) {
            throw new IOInputTooLongException(
                    sprintf('The input string (%d) was longer than the sum of fieldWidths (%d) in %s', $inputLength, $offset, __METHOD__)
            );
        }
        return $array;
    }

    /**
     * Format an array as a fixed width string.
     * 
     * Formats a line (passed as a fields array) as a fixed width string.
     * 
     * Assumptions:
     * Field padding character is a space.
     * 
     * @param mixed[] $fields       An array of string like things. Objects
     *                              in this array will be cast to strings before
     *                              processing. The keys of the array will be 
     *                              ignored.
     * @param int[]   $fieldWidths  An array of ints. The keys of the array will
     *                              be ignored.
     * @param bool $truncateFields  Whether or not to truncate fields. If this 
     *                              flag is TRUE, fields will be truncated to 
     *                              fit inside their corresponding fieldWidth.
     *                              If this flag is set to FALSE and a field is
     *                              longer than its fieldWidth, 
     *                              IOFieldOverflowException will be
     *                              thrown.
     * @return string               The formatted string.
     * @throws IOIllegalParameterException
     * @throws IOTooManyFieldsException
     * @throws IOTooFewFieldsException
     * @throws IOFieldOverflowException Only thrown if $truncateFields === TRUE
     */
    public static function array_formatfw(array $fields, array $fieldWidths, $truncateFields = FALSE) {
        if (!is_bool($truncateFields)) {
            throw new IOIllegalParameterException(
                    sprintf('truncateFields must be a boolean in %s', __METHOD__)
            );
        }
        if (count($fields) < count($fieldWidths)) {
            throw new IOTooFewFieldsException(
                    sprintf('Number of fieldWidths (%d) is more than the number of fields (%d) in %s', count($fieldWidths), count($fields), __METHOD__)
            );
        } elseif (count($fields) > count($fieldWidths)) {
            throw new IOTooManyFieldsException(
                    sprintf('Number of fieldWidths (%d) is less than the number of fields (%d) in %s', count($fieldWidths), count($fields), __METHOD__)
            );
        }
        $formattedString = '';
        while (count($fields) > 0 && count($fieldWidths) > 0) {
            $field = (string) array_shift($fields);
            $fieldWidth = array_shift($fieldWidths);
            if (!is_int($fieldWidth) || $fieldWidth < 0) {
                throw new IOIllegalParameterException(
                        sprintf('fieldWidths must be an array of ints in %s', __METHOD__)
                );
            }
            if (!$truncateFields && strlen($field) > $fieldWidth) {
                throw new IOFieldOverflowException(
                        sprintf('Length of field %s (%d) is greater than the fieldWidth (%d) in %s', $field, strlen($field), $fieldWidth, __METHOD__, $field)
                );
            }
            $formattedString .= str_pad(substr($field, 0, $fieldWidth), $fieldWidth, ' ', STR_PAD_RIGHT);
        }
        return $formattedString;
    }

    /**
     * Format a line as a fixed width string and write to the file pointer.
     * 
     * Formats a line (passed as a fields array) as a fixed width string and
     * writes it (terminated by a newline) to the specified file handle.
     *
     * @param resource $handle  The file pointer must be valid, and must point to
     *                          a file successfully opened by 
     *                          {@link http://www.php.net/manual/en/function.fopen.php fopen()}
     *                          or {@link http://www.php.net/manual/en/function.fsockopen.php fsockopen()}
     *                          (and not yet closed by
     *                          {@link http://www.php.net/manual/en/function.fclose.php fclose()}).
     * Assumptions:
     * Field padding character is a space.
     * 
     * @param mixed[] $fields       An array of string like things. Objects
     *                              in this array will be cast to strings before
     *                              processing. The keys of the array will be 
     *                              ignored.
     * @param int[]   $fieldWidths  An array of ints. The keys of the array will
     *                              be ignored.
     * @param string|NULL  $endOfLineSeparator  An optional end of line delimiter.
     *                              If this is null, the default PHP_EOL will be
     *                              used. If the delimiter is found inside any 
     *                              field, a 
     *                              IOEndOfLineSeparatorContainedInLineException
     *                              will be thrown.
     *                              Passing of an empty string ('') is reserved
     *                              for future use, and will throw a
     *                              IONotImplementedYetException.
     * @param bool $truncateFields  Whether or not to truncate fields. If this 
     *                              flag is TRUE, fields will be truncated to 
     *                              fit inside their corresponding fieldWidth.
     *                              If this flag is set to FALSE and a field is
     *                              longer than its fieldWidth, 
     *                              IOFieldOverflowException will be
     *                              thrown.
     * @return int|bool             Returns the number of bytes written, or
     *                              FALSE on error.
     * @throws IOIllegalParameterException
     * @throws IOTooManyFieldsException
     * @throws IOTooFewFieldsException
     * @throws IOFieldOverflowException Only thrown if $truncateFields === TRUE
     * @throws IOEndOfLineSeparatorContainedInLineException
     * @throws IONotImplementedYetException
     * @todo test that stream_get_line accepts multi character string endings.
     */
    public static function fputfw($handle, array $fields, array $fieldWidths, $endOfLineSeparator = NULL, $truncateFields = FALSE) {
        if (is_null($endOfLineSeparator)) {
            $endOfLineSeparator = PHP_EOL;
        }
        $endOfLineSeparator = (string) $endOfLineSeparator;
        if ('' == $endOfLineSeparator) {
            throw new IONotImplementedYetException(
                    sprintf('Empty string endOfLineSeparator is not implemented in %s', __METHOD__)
            );
        }
        $formattedString = static::array_formatfw($fields, $fieldWidths, $truncateFields);
        if (strpos($formattedString, $endOfLineSeparator) !== FALSE) {
            throw new IOEndOfLineSeparatorContainedInLineException(
                    sprintf("End of line separator '%s' found in line '%s' in %s", $endOfLineSeparator, $formattedString, __METHOD__)
            );
        }
        return fwrite($handle, $formattedString . $endOfLineSeparator);
    }

}