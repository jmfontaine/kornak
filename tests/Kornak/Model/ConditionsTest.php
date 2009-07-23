<?php
require_once dirname(__FILE__) . '/../../TestHelper.php';

require_once 'Kornak/Model/Conditions.php';

class Kornak_Model_ConditionsTest extends PHPUnit_Framework_TestCase
{
    /**
        Utility methods
    */
    public static function main()
    {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('Kornak_Model_ConditionsTest');
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
    public function testConstruct()
    {
        $expectedConditions = array(
            array(
                'property' => 'last_name',
                'value'    => 'doe',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_NONE,
            ),
        );
        
        $object = new Kornak_Model_Conditions('last_name', 'doe', '=');
        $this->assertSame($expectedConditions, $object->getConditions());
    }

    public function testConstructOperatorDefaultValue()
    {
        $expectedConditions = array(
            array(
                'property' => 'last_name',
                'value'    => 'doe',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_NONE,
            ),
        );
        
        $object = new Kornak_Model_Conditions('last_name', 'doe');
        $this->assertSame($expectedConditions, $object->getConditions());
    }
    
    public function testToString()
    {
        $dbAdapter = $this->getMock('Zend_Db_Adapter_Mysqli',
                                    array('quoteInto'),
                                    array(array('host'     => '127.0.0.1',
                                                'username' => 'root',
                                                'password' => '',
                                                'dbname'   => 'test')));
        $dbAdapter->expects($this->any())
                  ->method('quoteInto')
                  ->will($this->returnValue("name = 'doe'"));   
        Zend_Db_Table_Abstract::setDefaultAdapter($dbAdapter);
        
        $object = new Kornak_Model_Conditions('name', 'doe', '=');
        $this->assertSame($object->__toString(), $object->toSql());
    }
    
    public function testAndCondition()
    {
        $expectedConditions = array(
            array(
                'property' => 'last_name',
                'value'    => 'doe',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_NONE,
            ),
            array(
                'property' => 'first_name',
                'value'    => 'john',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_AND,
            ),
        );
        
        $object = new Kornak_Model_Conditions('last_name', 'doe', '=');
        $object->andCondition('first_name', 'john', '=');
        $this->assertSame($expectedConditions, $object->getConditions());
    }

    public function testAndConditionOperatorDefaultValue()
    {
        $expectedConditions = array(
            array(
                'property' => 'last_name',
                'value'    => 'doe',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_NONE,
            ),
            array(
                'property' => 'first_name',
                'value'    => 'john',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_AND,
            ),
        );
        
        $object = new Kornak_Model_Conditions('last_name', 'doe');
        $object->andCondition('first_name', 'john');
        $this->assertSame($expectedConditions, $object->getConditions());
    }

    public function testAndConditionEqualOperator()
    {
        $expectedConditions = array(
            array(
                'property' => 'last_name',
                'value'    => 'doe',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_NONE,
            ),
            array(
                'property' => 'first_name',
                'value'    => 'john',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_AND,
            ),
        );
        
        $object = new Kornak_Model_Conditions('last_name', 'doe', '=');
        $object->andCondition('first_name', 'john', '=');
        $this->assertSame($expectedConditions, $object->getConditions());
    }

    public function testAndConditionGreaterThanOperator()
    {
        $expectedConditions = array(
            array(
                'property' => 'last_name',
                'value'    => 'doe',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_NONE,
            ),
            array(
                'property' => 'income',
                'value'    => 40000,
                'operator' => '>',
                'type'     => Kornak_Model_Conditions::TYPE_AND,
            ),
        );
        
        $object = new Kornak_Model_Conditions('last_name', 'doe', '=');
        $object->andCondition('income', 40000, '>');
        $this->assertSame($expectedConditions, $object->getConditions());
    }
    
    public function testAndConditionInvalidOperator()
    {
        $this->setExpectedException('Kornak_Exception');
        $object = new Kornak_Model_Conditions('last_name', 'doe', '=');
        $object->andCondition('income', 40000, '~');
    }
    
    public function testOrCondition()
    {
        $expectedConditions = array(
            array(
                'property' => 'last_name',
                'value'    => 'doe',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_NONE,
            ),
            array(
                'property' => 'last_name',
                'value'    => 'smith',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_OR,
            ),
        );
        
        $object = new Kornak_Model_Conditions('last_name', 'doe', '=');
        $object->orCondition('last_name', 'smith', '=');
        $this->assertSame($expectedConditions, $object->getConditions());
    }

    public function testOrConditionOperatorDefaultValue()
    {
        $expectedConditions = array(
            array(
                'property' => 'last_name',
                'value'    => 'doe',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_NONE,
            ),
            array(
                'property' => 'last_name',
                'value'    => 'smith',
                'operator' => '=',
                'type'     => Kornak_Model_Conditions::TYPE_OR,
            ),
        );
        
        $object = new Kornak_Model_Conditions('last_name', 'doe');
        $object->orCondition('last_name', 'smith');
        $this->assertSame($expectedConditions, $object->getConditions());
    }    
    
    public function testToSql()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }
    
    /**
        Bugs tests
    */
}