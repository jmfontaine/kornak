<?php
class Kajoa_Form_Decorator_FormErrors extends Zend_Form_Decorator_Abstract
{
    protected $_placement = 'PREPEND';
    
    public function render($content)
    {
        $form    = $this->getElement();
        $view    = $form->getView();
        if (null === $view) {
            return $content;
        }

        // KLUDGE: Workaround bug #ZF-3477 (http://framework.zend.com/issues/browse/ZF-3477)
        $view->getHelper('formErrors')->setElementStart('<ul%s><li>');
        
        $errors = $form->getFormErrors();
        if (empty($errors)) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $errors    = $view->formErrors($errors, $this->getOptions()); 

        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $errors;
                break;
            case self::PREPEND:
                return $errors . $separator . $content;
                break;
        }
    }
}
