<?php
require_once dirname(__FILE__) . '/../../TestHelper.php';

require_once 'Kornak/Filter/MaxLength.php';

class Kornak_Filter_MaxLengthTest extends PHPUnit_Framework_TestCase
{
    /**
        Utility methods
    */
    public static function main()
    {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('Kornak_Filter_MaxLengthTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    /**
        Public functions tests
    */
    public function testConstruct()
    {
        $length = 10;
        $filter = new Kornak_Filter_MaxLength($length);
        $this->assertSame(
            $length,
            $filter->getMaxLength(),
            'The maximum length should be definable in the filter constructor'
        );
    }

    public function testFilter()
    {
        $filter = new Kornak_Filter_MaxLength(10);
        $this->assertSame(
            'A dummy bu',
            $filter->filter('A dummy but quite long string'),
            'The filter should cut the string to the defined length'
        );
    }

    public function testGetMaxLength()
    {
        $length = 10;
        $filter = new Kornak_Filter_MaxLength($length);
        $this->assertSame(
            $length,
            $filter->getMaxLength(),
            'The maximum length should be returned'
        );
    }

    public function testSetMaxLength()
    {
        $length = 10;
        $filter = new Kornak_Filter_MaxLength();
        $filter->setMaxLength($length);
        $this->assertSame(
            $length,
            $filter->getMaxLength(),
            'The maximum length should be definable'
        );

        $object = $filter->setMaxLength(12);
        $this->assertTrue(
            $object instanceof Zend_Filter_Interface,
            'The setters should implement fluent interface'
        );
    }

    /**
        Bugs tests
    */
}