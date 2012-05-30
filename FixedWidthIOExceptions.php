<?php

/**
 * A generic exception for the FixedWidthIO package 
 */
class FixedWidthIOException extends Exception {}

/**
 * Thrown when an illegal parameter is passed to a function in the FixedWidthIO
 * package. 
 */
class FixedWidthIOIllegalParameterException extends FixedWidthIOException {}

/**
 * Thrown when the sum of the fieldWidths exceeds the length of the input string 
 */
class FixedWidthIOInputTooShortException extends FixedWidthIOException {}

/**
 * Thrown when the input string is longer than the sum of fieldWidths 
 */
class FixedWidthIOInputTooLongException extends FixedWidthIOException {}