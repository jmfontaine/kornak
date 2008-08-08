<?php
/**
 * Test helper
 */
require_once dirname( __FILE__ ) . '/../../TestHelper.php';

if (! defined('PHPUnit_MAIN_METHOD')) {
	define('PHPUnit_MAIN_METHOD', 'Kajoa_Service_AllTests::main');
}
require_once 'Kajoa/Service/NabaztagTest.php';

class Kajoa_Service_AllTests
{
	public static function main()
	{
		PHPUnit_TextUI_TestRunner::run(self::suite());
	}
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('Kajoa - Kajoa_Service');
		$suite->addTestSuite('Kajoa_Service_NabaztagTest');
		return $suite;
	}
}

if (PHPUnit_MAIN_METHOD == 'Kajoa_Service_AllTests::main') {
	Kajoa_Service_AllTests::main();
}    