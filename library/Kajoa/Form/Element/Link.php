<?php
class Kajoa_Form_Element_Link extends Kajoa_Form_Element_Html
{
    public $helper = 'formLink';
    
    public function init()
    {
        parent::init();
        $this->class = 'link';
    } 

    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper');
        }
    }
    
    public function setLabel($label)
    {
        $this->setAttrib('label', $label);
        return $this;
    }
    
    public function setUrl($url)
    {
        if (is_array($url)) {
            $params = isset($url['params']) ? $url['params'] : array();
            $route  = isset($url['route']) ? $url['route'] : null;
            $reset  = isset($url['reset']) ? (bool) $url['reset'] : null; 
            
            $urlHelper = new Zend_View_Helper_Url();
            $url       = $urlHelper->url($params, $route, $reset);
            unset($urlHelper); 
        }
        
        $this->setAttrib('href', $url);
        return $this;
    }
}