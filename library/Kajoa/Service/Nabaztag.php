<?php
class Kajoa_Service_Nabaztag
{
    CONST API_URL = 'http://api.nabaztag.com/vl/FR/api.jsp';
    
    CONST VERSION_UNKNOWN = 'unknown';
    CONST VERSION_V1      = 'V1';
    CONST VERSION_V2      = 'V2';
    
    protected $_httpClient;
    protected $_serialNumber;
    protected $_token;
    
    protected function _checkEarPosition($position)
    {
        $position = (int) $position;
        if (0 > $position || 16 < $position) {
            $message = 'Ear position must be an integer between 0 and 16';
            throw new Kajoa_Service_Nabaztag_Exception($message);
        }
        return $position;
    }
    
    protected function _sendCommand($parameters)
    {
        $parameters['sn']    = $this->_serialNumber;
        $parameters['token'] = $this->_token;
        
        $httpClient = $this->getHttpClient();
        $httpClient->resetParameters();
        $httpClient->setParameterGet($parameters);
        $httpResponse = $httpClient->request();
        return new Kajoa_Service_Nabaztag_Response($httpResponse);
    }    
    
    public function __construct($serialNumber, $token)
    {
        $this->_serialNumber = $serialNumber;
        $this->_token        = $token;
    }

    public function getBlackList()
    {
        $response = $this->_sendCommand(array('action' => 6));
        
        if ($response->isError()) {
            return false;
        }
        
        $names = array();
        foreach ($response->getBody()->pseudo as $item) {
            $names[] = (string) $item['name'];
        }

        return $names;
    }
    
    public function getEarsPosition()
    {
        $response = $this->_sendCommand(array('ears' => 'ok'));
        
        if ($response->isError()) {
            return false;
        }
        
        $body = $response->getBody();
        return array(
            'left'  => (int) $body->leftposition,
            'right' => (int) $body->rightposition,
        );
    }

    public function getFriends()
    {
        $response = $this->_sendCommand(array('action' => 2));
        
        if ($response->isError()) {
            return false;
        }
        
        $names = array();
        foreach ($response->getBody()->friend as $item) {
            $names[] = (string) $item['name'];
        }

        return $names;
    }
    
    public function getHttpClient()
    {
        if (null === $this->_httpClient) {
            $this->setHttpClient(new Zend_Http_Client());
        }
        
        return $this->_httpClient;    
    }
    
    public function getLanguages()
    {
        $response = $this->_sendCommand(array('action' => 11));
        
        if ($response->isError()) {
            return false;
        }
        
        $languages = array();
        foreach ($response->getBody()->myLang as $item) {
            $languages[] = (string) $item['lang'];
        }

        return $languages;
    }
    
    public function getLeftEarPosition()
    {
        $response = $this->_sendCommand(array('ears' => 'ok'));
        
        if ($response->isError()) {
            return false;
        }
        
        return (int) $response->getBody()->leftposition;
    }

    public function getMessages()
    {
        $response = $this->_sendCommand(array('action' => 3));
        
        if ($response->isError()) {
            return false;
        }
        
        $messages = array();
        foreach ($response->getBody()->msg as $message) {
            $messages[] = new Kajoa_Service_Nabaztag_Message(
                (string) $message['from'],
                (string) $message['title'],
                (string) $message['date'],
                (string) $message['url']
            );
        }

        return $messages;
    }
    
    public function getName()
    {
        $response = $this->_sendCommand(array('action' => 10));
        
        if ($response->isError()) {
            return false;
        } else {
            return (string) $response->getBody()->rabbitName;
        }
    }
    
    public function getRightEarPosition()
    {
        $response = $this->_sendCommand(array('ears' => 'ok'));
        
        if ($response->isError()) {
            return false;
        }
        
        return (int) $response->getBody()->rightposition;
    }

    public function getSignature()
    {
        $response = $this->_sendCommand(array('action' => 5));
        
        if ($response->isError()) {
            return false;
        } else {
            return (string) $response->getBody()->signature;
        }
    }

    public function getTextToSpeechLanguages()
    {
        $response = $this->_sendCommand(array('action' => 9));
        
        if ($response->isError()) {
            return false;
        }
        
        $languages = array();
        foreach ($response->getBody()->voice as $item) {
            $languages[] = (string) $item['lang'];
        }

        return $languages;
    }
    
    public function getTextToSpeechVoices($language = null)
    {
        $response = $this->_sendCommand(array('action' => 9));
        
        if ($response->isError()) {
            return false;
        }
        
        $voices = array();
        foreach ($response->getBody()->voice as $item) {
            if (null === $language || (null !== $language && $language == $item['lang'])) {
                $voices[] = (string) $item['command'];
            }
        }

        return $voices;
    }
    
    public function getTimezone()
    {
        $response = $this->_sendCommand(array('action' => 4));
        
        if ($response->isError()) {
            return false;
        }
        
        return (string) $response->getBody()->timezone;
    }
    
    public function getVersion()
    {
        $response = $this->_sendCommand(array('action' => 8));
        
        if ($response->isError()) {
            return false;
        }
        
        switch($response->getBody()->rabbitVersion) {
            case self::VERSION_V1:
                return self::VERSION_V1;
                break;
            case self::VERSION_V2:
                return self::VERSION_V2;
                break;
            default:
                return self::VERSION_UNKNOWN;
                break;
        }
    }
        
    public function isSleeping()
    {
        $response = $this->_sendCommand(array('action' => 7));

        if ($response->isSuccessful()) {
            $body = $response->getBody();
            if ('NO' == $body->rabbitSleep) {
                return false;
            } elseif ('YES' == $body->rabbitSleep) {
                return true;
            }
        }
        
        return null;
    }
    
    public function sendTextMessage($message, $voice = null, $ttl = null)
    {
        $parameters = array('tts' => $message);
        
        if (null !== $voice) {
            $parameters['voice'] = $voice;
        }
        if (null !== $ttl) {
            $parameters['ttlive'] = $ttl;
        }
        
        $response = $this->_sendCommand($parameters);
        return $response->isSuccessful();    
    }

    public function setEarsPosition($leftEarPosition, $rightEarPosition)
    {
        $params = array(
            'posleft'  => $this->_checkEarPosition($leftEarPosition),
            'posright' => $this->_checkEarPosition($rightEarPosition),
        );
        
        $response =  $this->_sendCommand($params);
        return $response->isSuccessful();    
    }
    
    public function setHttpClient(Zend_Http_Client $client)
    {
        $client->setUri(self::API_URL);
        $client->setConfig(array('useragent' => __CLASS__));

        $this->_httpClient = $client;    
    }
    
    public function setLeftEarPosition($position)
    {
        $position = $this->_checkEarPosition($position);
                
        $response =  $this->_sendCommand(array('posleft' => $position));
        return $response->isSuccessful();    
    }

    public function setRightEarPosition($position)
    {
        $position = $this->_checkEarPosition($position);
        
        $response = $this->_sendCommand(array('posright' => $position));    
        return $response->isSuccessful();    
    }
    
    public function sleep()
    {
        $response = $this->_sendCommand(array('action' => 13));
        return $response->isSuccessful();    
    }
    
    public function wakeUp()
    {
        $response = $this->_sendCommand(array('action' => 14));
        return $response->isSuccessful();    
    }
}