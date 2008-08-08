<?php
require_once dirname(__FILE__) . '/../../TestHelper.php';
require_once 'Kajoa/Service/Nabaztag.php';

class Kajoa_Service_NabaztagTest extends PHPUnit_Framework_TestCase
{
    const SERIAL_NUMBER = '111111111111';
    const TOKEN         = '1111111111';
    protected $_nabaztag;
    
    /***
    * Utility methods
    */
    public static function main()
    {
        require_once 'PHPUnit/TextUI/TestRunner.php';
        $suite  = new PHPUnit_Framework_TestSuite('Kajoa_Service_NabaztagTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }
    
    protected function _getLastRequestQueryStringAsArray()
    {
        $uri    = $this->_getLastRequestUri();
        $parts  = explode('&', $uri->getQuery());
        $result = array();
        foreach($parts as $part) {
            $subParts = explode('=', $part);
            $result[$subParts[0]] = urldecode($subParts[1]);
        }
        return $result;
    }
    
    protected function _getLastRequestUri()
    {
        $rawRequest = $this->_nabaztag->getHttpClient()->getLastRequest();
        $uri        = Zend_Uri::factory('http');
        $lines      = explode("\r    ", $rawRequest);
        $firstLine  = explode(' ', $lines[0]);
        $parts      = parse_url($firstLine[1]);
        $uri->setPath($parts['path']);
        $uri->setQuery($parts['query']);
        foreach($lines as $line) {
            if ('Host:' == substr($line, 0, 5)) {
                $host = substr($line, 6);
                $uri->setHost($host);
                break;
            }
        }
        return $uri;
    }
    
    protected function _loadResponse($name)
    {
        $path = dirname(__FILE__) . '/_files/responses';
        return file_get_contents($path . "/$name.xml");
    }
    
    protected function _setHttpResponse($code, $responseName = null, $headers = array(), $version = '1.1')
    {
        $body = '';
        if (null !== $responseName) {
            $body = $this->_loadResponse($responseName);
        }
        
        $adapter = new Zend_Http_Client_Adapter_Test();
        $adapter->setResponse(new Zend_Http_Response($code, $headers, $body, $version));
        $httpClient = new Zend_Http_Client();
        $httpClient->setConfig(array('adapter' => $adapter));
        $this->_nabaztag->setHttpClient($httpClient);
    }
    
    protected function setUp()
    {
        $this->_nabaztag = new Kajoa_Service_Nabaztag(self::SERIAL_NUMBER, self::TOKEN);
    }
    
    protected function tearDown()
    {
        $this->_nabaztag = null;
    }
    
    /***
    * Public functions tests
    */
    public function testGetBlackList()
    {
        // Check response
        $this->_setHttpResponse(200, 'getBlackList1');
        $expectedResult = array('foo', 'bar',);
        $this->assertSame($expectedResult, $this->_nabaztag->getBlackList());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 6,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetBlackListEmptyList()
    {
        $this->_setHttpResponse(200, 'getBlackList2');
        $this->assertSame(array(), $this->_nabaztag->getBlackList());
    }
    
    public function testGetBlackListHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getBlackList());
    }
    
    public function testGetEarsPosition()
    {
        // Check response
        $this->_setHttpResponse(200, 'getEarsPosition');
        $expectedResult = array('left' => 12, 'right' => 4,);
        $this->assertSame($expectedResult, $this->_nabaztag->getEarsPosition());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'ears' => 'ok',);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetFriends()
    {
        // Check response
        $this->_setHttpResponse(200, 'getFriends');
        $expectedResult = array('Nabmaster', 'Dummy',);
        $this->assertSame($expectedResult, $this->_nabaztag->getFriends());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 2,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetFriendsHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getFriends());
    }
    
    public function testGetHttpClient()
    {
        $httpClient = new Zend_Http_Client();
        $this->_nabaztag->setHttpClient($httpClient);
        $returnHttpClient = $this->_nabaztag->getHttpClient();
        $this->assertSame($httpClient, $returnHttpClient);
    }
    
    public function testGetLanguages()
    {
        // Check response
        $this->_setHttpResponse(200, 'getLanguages');
        $expectedResult = array('fr', 'us', 'uk', 'de',);
        $this->assertSame($expectedResult, $this->_nabaztag->getLanguages());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 11,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetLanguagesHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getLanguages());
    }
    
    public function testGetLeftEarPosition()
    {
        // Check response
        $this->_setHttpResponse(200, 'getEarsPosition');
        $this->assertSame(12, $this->_nabaztag->getLeftEarPosition());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'ears' => 'ok',);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetMessages()
    {
        // Check response
        $this->_setHttpResponse(200, 'getMessages');
        $date           = strtotime('today 11:59');
        $date           = new Zend_Date($date);
        $expectedResult = array(new Kajoa_Service_Nabaztag_Message('toto', 'my message', $date, 'broad/001/948.mp3'),);
        $this->assertEquals($expectedResult, $this->_nabaztag->getMessages());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 3,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetMessagesHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getMessages());
    }
    
    public function testGetName()
    {
        // Check response
        $this->_setHttpResponse(200, 'getName');
        $this->assertSame('dummy', $this->_nabaztag->getName());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 10,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetNameHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getName());
    }
    
    public function testGetRightEarPosition()
    {
        // Check response
        $this->_setHttpResponse(200, 'getEarsPosition');
        $this->assertSame(4, $this->_nabaztag->getRightEarPosition());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'ears' => 'ok',);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetRightEarPositionHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getRightEarPosition());
    }
    
    public function testGetSignature()
    {
        // Check response
        $this->_setHttpResponse(200, 'getSignature');
        $this->assertSame('Dummy signature', $this->_nabaztag->getSignature());
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 5,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetSignatureHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getSignature());
    }
    
    public function testGetTextToSpeechLanguages()
    {
        // Check response
        $this->_setHttpResponse(200, 'getTextToSpeech');
        $expectedResult = array('fr', 'de',);
        $this->assertEquals($expectedResult, $this->_nabaztag->getTextToSpeechLanguages());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 9,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetTextToSpeechLanguagesHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getTextToSpeechLanguages());
    }
    
    public function testGetTextToSpeechVoices()
    {
        // Check response
        $this->_setHttpResponse(200, 'getTextToSpeech');
        $expectedResult = array('FR-Anastasie', 'DE-Otto',);
        $this->assertEquals($expectedResult, $this->_nabaztag->getTextToSpeechVoices());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 9,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetTextToSpeechVoicesHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getTextToSpeechVoices());
    }
    
    public function testGetTextToSpeechVoicesSpecificLanguage()
    {
        $this->_setHttpResponse(200, 'getTextToSpeech');
        $expectedResult = array('FR-Anastasie',);
        $this->assertEquals($expectedResult, $this->_nabaztag->getTextToSpeechVoices('fr'));
    }
    
    public function testGetTimezone()
    {
        // Check response
        $this->_setHttpResponse(200, 'getTimezone');
        $this->assertSame('(GMT + 01:00) Bruxelles, Copenhague, Madrid, Paris', $this->_nabaztag->getTimeZone());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 4,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetTimezoneHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getTimeZone());
    }
    
    public function testGetVersion()
    {
        // Check response
        $this->_setHttpResponse(200, 'getVersion1');
        $this->assertSame(Kajoa_Service_Nabaztag::VERSION_V2, $this->_nabaztag->getVersion());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 8,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testGetVersionHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->getVersion());
    }
    
    public function testGetVersionUnknownVersion()
    {
        $this->_setHttpResponse(200, 'getVersion2');
        $this->assertSame(Kajoa_Service_Nabaztag::VERSION_UNKNOWN, $this->_nabaztag->getVersion());
    }
    
    public function testIsSleeping()
    {
        // Check response
        $this->_setHttpResponse(200, 'isSleeping1');
        $this->assertFalse($this->_nabaztag->isSleeping());
        $this->_setHttpResponse(200, 'isSleeping2');
        $this->assertTrue($this->_nabaztag->isSleeping());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 7,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testIsSleepingHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertSame(null, $this->_nabaztag->isSleeping());
    }
    
    public function testSendTextMessage()
    {
        // Check response
        $this->_setHttpResponse(200, 'sendTextMessage');
        $this->assertTrue($this->_nabaztag->sendTextMessage('This is a test'));
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'tts' => 'This is a test',);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testSendTextMessageHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertSame(false, $this->_nabaztag->sendTextMessage('This is a test'));
    }
    
    public function testSetEarsPosition() {
        // Check response
        $this->_setHttpResponse(200, 'setEarsPosition1');
        $this->assertTrue($this->_nabaztag->setEarsPosition(4, 13));
        $this->assertTrue($this->_nabaztag->setEarsPosition('6', '14'));
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'posleft' => 6, 'posright' => 14,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testSetEarsPositionHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->setEarsPosition(4, 13));
    }
    
    public function testSetEarsPositionInvalidPosition() {
        // Check response
        $this->_setHttpResponse(200, 'setEarsPosition2');
        
        $this->setExpectedException('Kajoa_Service_Nabaztag_Exception');
        $this->_nabaztag->setEarsPosition(18, 4);

        $this->setExpectedException('Kajoa_Service_Nabaztag_Exception');
        $this->_nabaztag->setEarsPosition(4, 22);
    }
    
    public function testSetHttpClient()
    {
        $httpClient = new Zend_Http_Client();
        $this->_nabaztag->setHttpClient($httpClient);
        $returnHttpClient = $this->_nabaztag->getHttpClient();
        $this->assertSame($httpClient, $returnHttpClient);
    }
    
    public function testSetLeftEarPosition()
    {
        // Check response
        $this->_setHttpResponse(200, 'setEarsPosition1');
        $this->assertTrue($this->_nabaztag->setLeftEarPosition(12));
        $this->assertTrue($this->_nabaztag->setLeftEarPosition('8'));
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'posleft' => 8,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testSetLeftEarPositionHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->setLeftEarPosition(12));
    }
    
    public function testSetLeftEarPositionInvalidPosition()
    {
        // Check response
        $this->_setHttpResponse(200, 'setEarsPosition2');
        $this->setExpectedException('Kajoa_Service_Nabaztag_Exception');
        $this->_nabaztag->setLeftEarPosition(18);
    }
    
    public function testSetRightEarPosition()
    {
        // Check response
        $this->_setHttpResponse(200, 'setEarsPosition1');
        $this->assertTrue($this->_nabaztag->setRightEarPosition(4));
        $this->assertTrue($this->_nabaztag->setRightEarPosition('6'));
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'posright' => 6,);
        $actualResult = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testSetRightEarPositionHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->setRightEarPosition(12));
    }
    
    public function testSetRightEarPositionInvalidPosition()
    {
        // Check response
        $this->_setHttpResponse(200, 'setEarsPosition2');
        $this->setExpectedException('Kajoa_Service_Nabaztag_Exception');
        $this->_nabaztag->setLeftEarPosition(-2);
    }

    public function testSleep()
    {
        // Check response
        $this->_setHttpResponse(200, 'sleep');
        $this->assertTrue($this->_nabaztag->sleep());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 13,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testSleepHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->sleep());
    }
    
    public function testWakeUp()
    {
        // Check response
        $this->_setHttpResponse(200, 'wakeUp');
        $this->assertTrue($this->_nabaztag->wakeUp());
        
        // Check request
        $expectedResult = array('sn' => self::SERIAL_NUMBER, 'token' => self::TOKEN, 'action' => 14,);
        $actualResult   = $this->_getLastRequestQueryStringAsArray();
        $this->assertEquals($expectedResult, $actualResult);
    }
    
    public function testWakeUpHttpError()
    {
        $this->_setHttpResponse(500);
        $this->assertFalse($this->_nabaztag->wakeUp());
    }
    
    /**
     Bugs tests
     */
}
