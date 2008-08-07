<?php
/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Kajoa_AllTests::main');
}

require_once 'Kajoa/CryptTest.php';

class Kajoa_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Kajoa');

        $suite->addTestSuite('Kajoa_CryptTest');
        
        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Kajoa_AllTests::main') {
    Kajoa_AllTests::main();
}
