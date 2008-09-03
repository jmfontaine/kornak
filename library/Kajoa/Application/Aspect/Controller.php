<?php
require_once 'Kajoa/Application.php';
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Controller/Front.php';

class Kajoa_Application_Aspect_Controller extends Kajoa_Application_Aspect_Abstract
{
    public function init()
    {
        $path = Kajoa_Application::getInstance()->getApplicationPath();
        
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->addModuleDirectory($path . '/modules')
                        ->dispatch();
    }    
}