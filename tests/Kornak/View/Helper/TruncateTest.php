<?php
require_once dirname(__FILE__) . '/../../../TestHelper.php';

require_once 'Kornak/View/Helper/Truncate.php';

class Kornak_View_Helper_TruncateTest extends PHPUnit_Framework_TestCase
{
    protected $_helper;

    /**
        Utility methods
    */
    public static function main()
    {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('Kornak_View_Helper_TruncateTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    protected function setUp()
    {
        $this->_helper = new Kornak_View_Helper_Truncate();
    }

    protected function tearDown()
    {
        $this->_helper = null;
    }

    /**
        Public functions tests
    */
    public function testTruncate()
    {
        $result = $this->_helper->truncate('A very very very very very long text');
        $this->assertEquals('A very very very very very lo…', $result);
    }

    public function testTruncateWithCustomLength()
    {
        $result = $this->_helper->truncate('A very very very very very long text', 10);
        $this->assertEquals('A very ve…', $result);
    }

    /**
        Bugs tests
    */
}