<?php
/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kornak_AllTests::main');
}

require_once 'Kornak/Filter/AllTests.php';
require_once 'Kornak/Model/AllTests.php';
require_once 'Kornak/Text/AllTests.php';

class Kornak_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kornak');

        $suite->addTest(Kornak_Filter_AllTests::suite());
        $suite->addTest(Kornak_Model_AllTests::suite());
        $suite->addTest(Kornak_Text_AllTests::suite());

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kornak_AllTests::main') {
    Kornak_AllTests::main();
}
