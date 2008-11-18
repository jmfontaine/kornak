<?php
require_once 'Zend/Filter/Interface.php';

class Kajoa_Filter_MaxLength implements Zend_Filter_Interface
{

    protected $_maxLength;

    public function __construct($maxLength = null)
    {
        $this->setMaxLength($maxLength);
    }

    public function filter($value)
    {
        return substr($value, 0, $this->_maxLength);
    }

    public function getMaxLength()
    {
        return $this->_maxLength;
    }

    public function setMaxLength($length)
    {
        $this->_maxLength = $length;
        return $this;
    }
}