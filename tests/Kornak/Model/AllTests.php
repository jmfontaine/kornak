<?php
/**
 * Test helper
 */
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kornak_Model_AllTests::main');
}

require_once 'Kornak/Model/ConditionsTest.php';

class Kornak_Model_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kornak - Kornak_Model');

        $suite->addTestSuite('Kornak_Model_ConditionsTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kornak_Model_AllTests::main') {
    Kornak_Model_AllTests::main();
}
