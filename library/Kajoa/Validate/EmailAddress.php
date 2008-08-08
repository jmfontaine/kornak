<?php
class Kajoa_Validate_EmailAddress extends Zend_Validate_EmailAddress
{
    public function isValid($value)
    {
        $isValid = parent::isValid($value);
        
        // Ensure there is only one error message
        if (!$isValid) {
            $this->_errors   = array();
            $this->_messages = array();
            $this->_error(self::INVALID);
        }
        
        return $isValid;
    }
}