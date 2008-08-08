<?php
class Kajoa_Form_Element_Hidden extends Zend_Form_Element_Hidden
{
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                 ->addDecorator('HtmlTag', array('tag' => 'dd'));
        }
    }
}
