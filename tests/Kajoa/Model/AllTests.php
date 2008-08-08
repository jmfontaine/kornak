<?php
/**
 * Test helper
 */
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kajoa_Model_AllTests::main');
}

require_once 'Kajoa/Model/ConditionsTest.php';

class Kajoa_Model_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kajoa - Kajoa_Model');

        $suite->addTestSuite('Kajoa_Model_ConditionsTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kajoa_Model_AllTests::main') {
    Kajoa_Model_AllTests::main();
}
