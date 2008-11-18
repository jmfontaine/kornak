<?php
/**
 * Test helper
 */
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kajoa_Filter_AllTests::main');
}

require_once 'Kajoa/Filter/MaxLengthTest.php';

class Kajoa_Filter_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kajoa - Kajoa_Filter');

        $suite->addTestSuite('Kajoa_Filter_MaxLengthTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kajoa_Filter_AllTests::main') {
    Kajoa_Filter_AllTests::main();
}
