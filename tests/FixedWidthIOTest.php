<?php

require_once dirname(__FILE__) . '/../FixedWidthIO.php';

/**
 * Test class for FixedWidthIO.
 * Generated by PHPUnit on 2012-05-29 at 15:47:42.
 */
class FixedWidthIOTest extends PHPUnit_Framework_TestCase {

    /**
     * @var FixedWidthIO
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     *@expectedException FixedWidthIOIllegalParameterException
     */
    public function testStr_getfwThrowsFixedWidthIOIllegalParameterExceptionWhenFieldWidthsIsArrayOfNotInts() {
        FixedWidthIO::str_getfw('abcxyz', array('a'));
    }
    
    /**
     *@expectedException FixedWidthIOInputTooShortException
     */
    public function testStr_getfwThrowsFixedWidthIOInputTooShortException() {
        FixedWidthIO::str_getfw('abcdefgh', array(3, 3, 3));
    }
    
    /**
     *@expectedException FixedWidthIOInputTooLongException
     */
    public function testStr_getfwThrowsFixedWidthIOInputTooLongException() {
        FixedWidthIO::str_getfw('abcdefg', array(3, 3));
    }


    /**
     * @covers FixedWidthIO::str_getfw
     * @dataProvider str_getfwProvider
     */
    public function testStr_getfw($string, $fieldWidths, $expectedResult) {
    
        $result = FixedWidthIO::str_getfw($string, $fieldWidths);
        $this->assertSame($expectedResult, $result);
        
    }

    public function str_getfwProvider() {
        return array(
            array("Foo Bob Baz ", array(4, 4, 4), array('Foo', 'Bob', 'Baz')),
            array("12345", array(1, 2, 2), array('1', '23', '45')),
            array("a", array(1), array('a')),
            array("Foo   10    Test                XYZ  1234",
                array('name' => 6, 'number' => 6, 'street' => 20, 'test' => 5, 'code' => 4),
                array('name' => 'Foo', 'number' => '10', 'street' => 'Test', 'test' => 'XYZ', 'code' => '1234')),
        );
    }

}

?>
