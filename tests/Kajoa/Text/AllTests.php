<?php
/**
 * Test helper
 */
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kajoa_Text_AllTests::main');
}

require_once 'Kajoa/Text/PasswordTest.php';

class Kajoa_Text_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kajoa - Kajoa_Text');

        $suite->addTestSuite('Kajoa_Text_PasswordTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kajoa_Text_AllTests::main') {
    Kajoa_Model_AllTests::main();
}
