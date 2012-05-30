<?php

require_once dirname(__FILE__) . '/../FixedWidthIO.php';
require_once dirname(__FILE__) . '/dependencies/vendor/autoload.php';

use org\bovigo\vfs;

/**
 * Test class for FixedWidthIO.
 * Generated by PHPUnit on 2012-05-30 at 13:32:12.
 */
class FixedWidthIOTest extends PHPUnit_Framework_TestCase {

    protected static $directory = '';
    protected static $filename = '';
    protected static $streamUrl = '';
    protected $handle = NULL;
    protected $file = NULL;

    public static function setUpBeforeClass() {
        static::$directory = 'test';
        static::$filename = self::$directory . DIRECTORY_SEPARATOR . 'test.fw';
        static::$streamUrl = vfs\vfsStream::url(static::$filename);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        vfs\vfsStreamWrapper::register();
        vfs\vfsStreamWrapper::setRoot(new vfs\vfsStreamDirectory('test'));
        $this->handle = fopen(static::$streamUrl, 'w');
        $this->file = vfs\vfsStreamWrapper::getRoot()->getChild(static::$filename);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        fclose($this->handle);
    }

    /**
     * @covers FixedWidthIO::fputfw
     * @dataProvider fputfwProvider
     */
    public function testFputfw($data, $fieldWidths, $endOfLineDelimiter, $truncateFields, $expected) {
        $expectedLineLength = strlen($endOfLineDelimiter);
        foreach ($fieldWidths as $fieldWidth) {
            $expectedLineLength += $fieldWidth;
        }
        foreach ($data as $fields) {
            $numBytes = FixedWidthIO::fputfw($this->handle, $fields, $fieldWidths, $endOfLineDelimiter, $truncateFields);
            $this->assertSame($expectedLineLength, $numBytes);
        }
        $this->assertSame($expected, $this->file->getContent());
    }

    public function fputfwProvider() {
        return array(
            array(
                array(array('abc', 'xyz')),
                array(4, 4,),
                "\n",
                FALSE,
                "abc xyz \n"
            ),
            array(
                array(
                    array('abc', 'xyz'),
                    array('foo', 'bar')
                ),
                array(4, 4),
                "\n",
                FALSE,
                "abc xyz \nfoo bar \n"
            )
        );
    }

    /**
     * This is just a sanity check.
     * The idea of this is to ensure that the FixedWidthIO::fputfw function
     * returns the same kind of count as the native fputcsv function,
     * in particular that this count includes the end of line marker.
     * This is not documented in the manual, but testing has concluded that it is.
     */
    public function testFputcsvLineLength() {
        $length = fputcsv($this->handle, array('aaa', 'bbb', 'ccc', 'dddd')); // 13 chars + 3 commas = 16.
        $this->assertSame(17, $length, sprintf(
                        'Expected length was 17 (13 chars + 3 commas = 16 + \n), actual length was %s. ' .
                        'Perhaps the end of line character was not included?', $length)
        );
    }

}

?>
