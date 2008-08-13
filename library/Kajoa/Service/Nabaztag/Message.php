<?php
class Kajoa_Service_Nabaztag_Message
{
    protected $_date;
    protected $_from;
    protected $_title;
    protected $_url;
    
    public function __construct($from, $title, $date, $url)
    {
        $date = strtotime($date);
        $this->_date  = new Zend_Date($date);
        $this->_from  = $from;
        $this->_title = $title;
        $this->_url   = $url;    
    }
    
    public function getDate()
    {
        return $this->_date;
    }

    public function getFrom()
    {
        return $this->_from;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getUrl()
    {
        return $this->_url;
    }
}