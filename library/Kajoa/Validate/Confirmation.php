<?php
class Kajoa_Validate_Confirmation extends Zend_Validate_Abstract
{
    const NOT_MATCH = 'confirmationNotMatch';  
   
    protected $_messageTemplates = array(  
        self::NOT_MATCH => 'Confirmation does not match'  
    );  
   
    protected $_fieldsToMatch = array();  
   
    public function __construct($fieldsToMatch = array()) {  
        if (is_array($fieldsToMatch)) {  
            foreach ($fieldsToMatch as $field) {  
                $this->_fieldsToMatch[] = (string) $field;  
            }  
        } else {  
            $this->_fieldsToMatch[] = (string) $fieldsToMatch;  
        }  
    }  
   
    public function isValid($value, $context = null) {  
        $error = false;  
        foreach ($this->_fieldsToMatch as $fieldName) {  
            if (!isset($context[$fieldName]) || $value != $context[$fieldName]) {  
                $error = true;  
                $this->_error(self::NOT_MATCH);  
                break;  
            }  
        }  
        return !$error;  
    }      
}