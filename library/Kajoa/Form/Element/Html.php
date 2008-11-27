<?php
class Kajoa_Form_Element_Html extends Kajoa_Form_Element_Xhtml
{
    protected $_html;

    public $helper = 'formHtml';

    public function getHtml()
    {
        return $this->_html;
    }

    public function render(Zend_View_Interface $view = null)
    {
        $this->setValue($this->getHtml());
        return parent::render($view);
    }

    public function setHtml($html)
    {
        $this->_html = $html;
        return $this;
    }
}