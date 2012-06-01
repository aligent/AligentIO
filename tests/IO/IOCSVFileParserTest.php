<?php

require_once dirname(__FILE__) . '/../../IO/IOCSVFileParser.php';
require_once dirname(__FILE__) . '/../dependencies/vendor/autoload.php';

use org\bovigo\vfs;

/**
 * Test class for IOCSVFileParser.
 * Generated by PHPUnit on 2012-06-01 at 09:18:30.
 */
class IOCSVFileParserTest extends PHPUnit_Framework_TestCase {

    protected static $directory = '';
    protected static $filename = '';
    protected static $filePath = '';
    protected static $streamUrl = '';
    protected $handle = NULL;
    protected $file = NULL;
    protected $fileParser;

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
this,"is",1234,A,"1234",test
"this",is,"1234",another,1234,TEST
EOD
        );
        $this->handle = fopen(static::$streamUrl, 'r');
        $this->fileParser = new IOCSVFileParser($this->handle);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        fclose($this->handle);
    }

    /**
     */
    public function testReadLine() {
        $line = $this->fileParser->readLine();
        $this->assertSame(array('this', 'is', '1234', 'A', '1234', 'test'), $line, 'Test1');
        $line2 = $this->fileParser->readLine();
        $this->assertSame(array('this', 'is', '1234', 'another', '1234', 'TEST'), $line2, 'Test2');
        $line3 = $this->fileParser->readLine();
        $this->assertFalse($line3, 'Test3');
    }

}

?>
