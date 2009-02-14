<?php
require_once dirname(__FILE__) . '/../../TestHelper.php';

require_once 'Kajoa/Text/Password.php';

class Kajoa_Text_PasswordTest extends PHPUnit_Framework_TestCase
{
    /**
        Utility methods
    */
    public static function main()
    {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('Kajoa_Text_PasswordTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    /**
        Public functions tests
    */
    public function testGeneratePassword()
    {
        $password = Kajoa_Text_Password::generatePassword();
        $this->assertTrue(8 == strlen($password));

        $password = Kajoa_Text_Password::generatePassword(16);
        $this->assertTrue(16 == strlen($password));
    }

    public function testGeneratePronounceablePassword()
    {
        $password = Kajoa_Text_Password::generatePronounceablePassword(16);
        $this->assertRegExp('/^[a-z]{16}$/', $password);
    }

    public function testGenerateUnpronounceablePassword()
    {
        $password = Kajoa_Text_Password::generateUnpronounceablePassword(12);
        $this->assertRegExp('/^[a-zA-Z0-9]{12}$/', $password);
    }

    /**
        Bugs tests
    */
}