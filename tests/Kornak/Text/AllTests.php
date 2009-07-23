<?php
/**
 * Test helper
 */
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kornak_Text_AllTests::main');
}

require_once 'Kornak/Text/PasswordTest.php';

class Kornak_Text_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kornak - Kornak_Text');

        $suite->addTestSuite('Kornak_Text_PasswordTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kornak_Text_AllTests::main') {
    Kornak_Text_AllTests::main();
}
