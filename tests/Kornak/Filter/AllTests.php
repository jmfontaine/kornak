<?php
/**
 * Test helper
 */
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kornak_Filter_AllTests::main');
}

require_once 'Kornak/Filter/MaxLengthTest.php';

class Kornak_Filter_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kornak - Kornak_Filter');

        $suite->addTestSuite('Kornak_Filter_MaxLengthTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kornak_Filter_AllTests::main') {
    Kornak_Filter_AllTests::main();
}
