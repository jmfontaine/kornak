<?php
/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../../../TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kornak_View_Helper_AllTests::main');
}

require_once 'Kornak/View/Helper/Truncate.php';

class Kornak_View_Helper_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kornak - Kornak_View_Helper');

        $suite->addTestSuite('Kornak_View_Helper_TruncateTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kornak_View_Helper_AllTests::main') {
    Kornak_View_Helper_AllTests::main();
}
