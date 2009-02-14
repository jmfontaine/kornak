<?php
/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kajoa_AllTests::main');
}

require_once 'Kajoa/Filter/AllTests.php';
require_once 'Kajoa/Model/AllTests.php';
require_once 'Kajoa/Text/AllTests.php';

class Kajoa_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kajoa');

        $suite->addTest(Kajoa_Filter_AllTests::suite());
        $suite->addTest(Kajoa_Model_AllTests::suite());
        $suite->addTest(Kajoa_Text_AllTests::suite());

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kajoa_AllTests::main') {
    Kajoa_AllTests::main();
}
