<?php
class Kajoa_Form_Element_Image extends Zend_Form_Element_Image
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
                 ->addDecorator('Errors')
                 ->addDecorator('HtmlTag', array('tag' => 'dd'))
                 ->addDecorator('Label', array('tag' => 'dt', 'requiredSuffix' => '*'));
        }
    }
}
