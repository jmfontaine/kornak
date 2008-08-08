<?php
/**
 * This class was heavily inspired by Rob Allen's following blog entries :
 * 
 * @link http://akrabat.com/2008/04/07/simple-zend_form-file-upload-example/ Simple Zend_Form File Upload Example 
 * @link http://akrabat.com/2008/05/16/simple-zend_form-file-upload-example-revisited/ Simple Zend_Form File Upload Example Revisited
 */
class Kajoa_Form_Element_File extends Zend_Form_Element_Xhtml
{
    /**
     * Flag indicating whether or not to insert FileUpload validator when element is required
     * @var bool
     */
    protected $_autoInsertFileUploadValidator = true;

    /**
     * Default view helper to use
     * @var string
     */
    public $helper = 'formFile';
    
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                 ->addDecorator('Description')
                 ->addDecorator('Errors')
                 ->addDecorator('HtmlTag', array('tag' => 'dd'))
                 ->addDecorator('Label', array('tag' => 'dt', 'requiredSuffix' => '*'));
        }
    }
    
    /**
     * Set flag indicating whether a FileUpload validator should be inserted when element is required
     * 
     * @param  bool $flag 
     * @return Zend_Form_Element
     */
    public function setAutoInsertFileUploadValidator($flag)
    {
        $this->_autoInsertFileUploadValidator = (bool) $flag;
        return $this;
    }

    /**
     * Get flag indicating whether a FileUpload validator should be inserted when element is required
     * 
     * @return bool
     */
    public function autoInsertFileUploadValidator()
    {
        return $this->_autoInsertFileUploadValidator;
    }
    
    
    public function isValid($value, $context = null)
    {
        $key  = $this->getName();
        $form = $this->getBelongsTo();
        if(null === $value) {
            if(isset($_FILES[$key])) {
                $value = new Kajoa_Form_Element_File_Value($_FILES[$key], ArrayObject::ARRAY_AS_PROPS);
            } elseif(!empty($_FILES[$form]['name'][$key])) {
                $value = new Kajoa_Form_Element_File_Value(
                    array(
                        'name'     => $_FILES[$form]['name'][$key],
                        'tmp_name' => $_FILES[$form]['tmp_name'][$key],
                        'type'     => $_FILES[$form]['type'][$key],
                        'error'    => $_FILES[$form]['error'][$key],
                        'size'     => $_FILES[$form]['size'][$key]
                    ),
                    ArrayObject::ARRAY_AS_PROPS
                );
            }
        }
        
        // Auto insert FileUpload validator
        if ($this->autoInsertFileUploadValidator()
            && !$this->getValidator('FileUpload'))
        {
            $fileValidator = new Kajoa_Validate_FileUpload($this->isRequired());
            
            $validators = $this->getValidators();
            $fileUpload = array('validator' => $fileValidator, 'breakChainOnFailure' => true);
            array_unshift($validators, $fileUpload);
            $this->setValidators($validators);
            
            // Do not use the automatic NotEmpty validator as FileUpload replaces it 
            $this->setAutoInsertNotEmptyValidator(false);
        }

        return parent::isValid($value, $context);
    }
}