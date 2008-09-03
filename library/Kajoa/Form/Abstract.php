<?php
class Kajoa_Form_Abstract extends Zend_Form
{
    protected $_buttonsDecorators = array(
        'FormElements',
        array('HtmlTag', array('tag' => 'dd', 'class' => 'buttons')),
    );
    
    protected $_buttonsTextDecorators = array(
        'ViewHelper',
    );
    
    protected $_formErrors = array();
    
    protected $_groupedElementDecorators = array(
        'ViewHelper',
        array('HtmlTag', array('tag' => 'dd')),
    );
    
    public function __construct ($options = null)
    {
        $this->addPrefixPath('Kajoa_Form', 'Kajoa/Form');

        $this->setMethod('post')
             ->setAttrib('accept-charset', 'UTF-8');        
        
        parent::__construct($options);
    }
    
    public function addFormError($error)
    {
        if (!is_string($error)) {
            throw new Kajoa_Exception('$error must be a string');
        }
        
        $this->_formErrors[] = $error;
    }
    
    public function getButtonsDecorators()
    {
        return $this->_buttonsDecorators;
    }
    
    public function getButtonsTextDecorators()
    {
        return $this->_buttonsTextDecorators;
    }
    
    public function getGroupedElementDecorators()
    {
        return $this->_groupedElementDecorators;
    }
    
    public function getFormErrors()
    {
        return $this->_formErrors;
    }

    public function hasFormErrors()
    {
        return !empty($this->_formErrors);
    }
    
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
                 ->addDecorator('HtmlTag', array('tag' => 'dl'))
                 ->addDecorator('FormErrors', array('class' => 'form-errors'))
                 ->addDecorator('Form');
        }
    }

    public function setFormErrors($errors)
    {
        if (is_array($errors)) {
            $this->_formErrors = $errors;
        } else if (is_string($errors)) {
            $this->_formErrors = array($errors);
        } else {
            throw new Kajoa_Exception('$error must be a string or an array');
        }
    }
}