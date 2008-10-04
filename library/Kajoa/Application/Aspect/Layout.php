<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Layout.php';

class Kajoa_Application_Aspect_Layout extends Kajoa_Application_Aspect_Abstract
{
    public function init()
    {
        $layout = Zend_Layout::startMvc();

        $applicationPath = $this->getApplication()->getApplicationPath();
        $layout->setLayoutPath($applicationPath . '/modules');
    }    
}