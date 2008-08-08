<?php
class Kajoa_Service_Nabaztag_Response
{
    protected $_body;
    protected $_isError;
    
    public function __construct(Zend_Http_Response $httpResponse)
    {
        $this->_isError = $httpResponse->isError();
        if (!$this->_isError) {
            $this->_body = new SimpleXMLElement($httpResponse->getBody());
        }
    }
    
    public function getBody()
    {
        return $this->_body;
    }

    public function isError()
    {
        return $this->_isError;
    }

    public function isSuccessful()
    {
        return !$this->_isError;
    }
}