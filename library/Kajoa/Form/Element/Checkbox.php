<?php
class Kajoa_Form_Element_Checkbox extends Zend_Form_Element_Checkbox
{
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                 ->addDecorator('Description')
                 ->addDecorator('Label', array('placement' => 'append', 'requiredSuffix' => '*'))
                 ->addDecorator('Errors')
                 ->addDecorator('HtmlTag', array('tag' => 'dd', 'class' => 'checkbox'));
        }
    }
}
