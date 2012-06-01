<?php

require_once dirname(__FILE__) . '/../../IO/IOCSVFileIterator.php';
require_once dirname(__FILE__) . '/../dependencies/vendor/autoload.php';

use org\bovigo\vfs;

/**
 * Test class for IOCSVFileIterator.
 * Generated by PHPUnit on 2012-06-01 at 11:39:50.
 */
class IOCSVFileIteratorTest extends PHPUnit_Framework_TestCase {

    protected static $directory = '';
    protected static $filename = '';
    protected static $filePath = '';
    protected static $streamUrl = '';
    protected $handle = NULL;
    protected $file = NULL;
    protected $expectedValues = array(
        array('c1' => 1, 'c2' => 'One', 'c3' => 'Line One'),
        array('c1' => 2, 'c2' => 'Two', 'c3' => 'Line Two'),
        array('c1' => 3, 'c2' => 'Three', 'c3' => 'Line Three')
    );
//    Array(
//        'name' => '', // The name to use as an index for any returned array of fields.
//        'label' => '', // The Label used to validate the file headers.
//        'fieldWidth' => NULL,
//        'readProcessor' => NULL, // callable. Any type of callback than can be supplied as the $callback parameter of call_user_func. Must accept a single string argument (the field value to be procesed) and return either a string (the processed field value) or FALSE. A FALSE return value is used to indicate that validation has failed, and a subsequent ValidationException will be thrown.
//        'writeProcessor' => NULL, // as per readProcessor.
//        'allowTruncate' => FALSE,
//    )

    protected $fieldProperties = array(
        array(
            'name' => 'c1',
            'label' => 'Col1',
            'readProcessor' => array('IOCSVFileIteratorTest', 'validateInt')
        ),
        array(
            'name' => 'c2',
            'label' => 'Col2'
        ),
        array(
            'name' => 'c3',
            'label' => 'Col3'
        ),
    );

    public static function validateInt($value) {
        return filter_var($value, FILTER_VALIDATE_INT);
    }

    /**
     * @var type IOCSVFileIterator
     */
    protected $csvFileIterator = NULL;

    public static function setUpBeforeClass() {
        static::$directory = 'test';
        static::$filename = 'test.csv';
        static::$filePath = self::$directory . DIRECTORY_SEPARATOR . self::$filename;
        static::$streamUrl = vfs\vfsStream::url(static::$filename);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        vfs\vfsStreamWrapper::register();
        vfs\vfsStreamWrapper::setRoot(new vfs\vfsStreamDirectory('test'));
        vfs\vfsStreamWrapper::getRoot()->addChild(new vfs\vfsStreamFile('test.csv'));
        $this->file = vfs\vfsStreamWrapper::getRoot()->getChild(static::$filename);
        $this->file->setContent(
                <<<EOD
Col1,Col2,Col3
1,One,Line One
2,Two,Line Two
3,Three,Line Three
EOD
        );
        $this->handle = fopen(static::$streamUrl, 'r');
        $this->csvFileIterator = new IOCSVFileIterator($this->handle);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
//        fclose($this->handle);  // don't close the handle so tests can pass the object among themselves.
    }

    /**
     * @covers IOFileIterator::getException
     * @todo Implement testGetException().
     */
    public function testGetException() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @expectedException IOObjectAlreadyInitializedException
     */
    public function testInitializeCanOnlyBeCalledOnce1() {
        $this->csvFileIterator->initialize($this->fieldProperties, TRUE);
        $this->csvFileIterator->initialize($this->fieldProperties, TRUE);
    }

    public function testIsHeaderMatch() {
        $isHeaderMatch = $this->csvFileIterator->initialize($this->fieldProperties, TRUE);
        $this->assertTrue($isHeaderMatch);
        return $this->csvFileIterator;
    }

    /**
     * @depends testIsHeaderMatch
     */
    public function testReadNextLineAfterHeader(IOCSVFileIterator $csvFileIterator) {
        $line = $csvFileIterator->current();
        $this->assertSame($this->expectedValues[0], $line);
        $csvFileIterator->next();
        $line = $csvFileIterator->current();
        $this->assertSame($this->expectedValues[1], $line);
        return $csvFileIterator;
    }

    /**
     * @depends testReadNextLineAfterHeader
     */
    public function testReadAfterRewindWithHeaderRow(IOCSVFileIterator $csvFileIterator) {
        $csvFileIterator->rewind();
        $line = $csvFileIterator->current();
        $this->assertSame($this->expectedValues[0], $line);
        $csvFileIterator->next();
        $line = $csvFileIterator->current();
        $this->assertSame($this->expectedValues[1], $line);
        return $csvFileIterator;
    }

    public function testNotIsHeaderMatch() {
        $isHeaderMatch = $this->csvFileIterator->initialize(NULL, TRUE);
        $this->assertFalse($isHeaderMatch);
    }

    public function testNotIsHeaderMatch2() {
        $isHeaderMatch = $this->csvFileIterator->initialize(array(
            array('label' => 'c1'),
            array('label' => 'c2'),
            array('label' => 'c3')
                ), TRUE);
        $this->assertFalse($isHeaderMatch);
    }

    public function testNotIsHeaderMatch3() {
        $isHeaderMatch = $this->csvFileIterator->initialize(array(
            array('label' => 'Col1'),
            array('label' => 'Col2')
                ), TRUE);
        $this->assertFalse($isHeaderMatch);
        return $this->csvFileIterator;
    }

    /**
     * @depends testNotIsHeaderMatch3
     */
    public function testNotIsHeaderMatch3ProducesIOTooManyFieldsException(IOCSVFileIterator $csvFileIterator) {
        $exception = $csvFileIterator->getException();
        $this->assertSame('IOTooManyFieldsException', get_class($exception));
        return $csvFileIterator;
    }

    /**
     * @depends testNotIsHeaderMatch3ProducesIOTooManyFieldsException
     */
    public function testGetExceptionResetsAfterCall(IOCSVFileIterator $csvFileIterator) {
        $this->assertNull($csvFileIterator->getException(), 'getException() should return NULL on subsequent call');
    }

    public function testNotIsHeaderMatch4() {
        $isHeaderMatch = $this->csvFileIterator->initialize(array(
            array('label' => 'Col1'),
            array('label' => 'Col2'),
            array('label' => 'Col3'),
            array('label' => 'Col4'),
                ), TRUE);
        $this->assertFalse($isHeaderMatch);
        return $this->csvFileIterator;
    }

    /**
     * @depends testNotIsHeaderMatch4
     */
    public function testNotIsHeaderMatch4ProducesIOTooFewFieldsException(IOCSVFileIterator $csvFileIterator) {
        $exception = $csvFileIterator->getException();
        $this->assertSame('IOTooFewFieldsException', get_class($exception));
    }

}