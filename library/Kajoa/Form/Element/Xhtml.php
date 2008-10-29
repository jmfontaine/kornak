<?php
require_once 'Zend/Form/Element/Xhtml.php';

class Kajoa_Form_Element_Xhtml extends Zend_Form_Element_Xhtml
{
    protected $_includeErrors = true;
    
    protected $_requiredSuffix = 'required';
    
    public function __construct($spec, $options = null)
    {
        $this->addPrefixPath('Kajoa_Form_', 'Kajoa/Form/');
        parent::__construct($spec, $options = null);
    }
    
    public function getRequiredSuffix()
    {
        return $this->_requiredSuffix;
    }
    
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                 ->addDecorator('HtmlTag', array('tag' => 'dd'))
                 ->addDecorator(
                    'Label',
                    array(
                        'tag'            => 'dt',
                        'requiredSuffix' => $this->_requiredSuffix,
                        'includeErrors'  => $this->_includeErrors,
                    )
                 );
        }
    }
    
    public function setRequiredSuffix($value, $escape = true)
    {
        $this->_requiredSuffix = $value;
        
        // Update default "Label" decorator because it is loaded
        // before this method is called
        if (!$this->loadDefaultDecoratorsIsDisabled()) {
              $decorator = $this->getDecorator('Label');
              $decorator->setOption('requiredSuffix', $this->_requiredSuffix);
              $decorator->setOption('escape', $escape);
        }
        
        return $this;
    }
}