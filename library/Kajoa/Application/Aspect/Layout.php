<?php
require_once 'Kajoa/Application.php';
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Layout.php';

class Kajoa_Application_Aspect_Layout extends Kajoa_Application_Aspect_Abstract
{
    public function init()
    {
        $layout = Zend_Layout::startMvc();

        $applicationPath = Kajoa_Application::getInstance()->getApplicationPath();
        $layout->setLayoutPath($applicationPath . '/modules');
    }    
}