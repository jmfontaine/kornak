<?php
require_once "Zend/Loader.php";

class Kajoa_Loader extends Zend_Loader
{
    public static function loadModel($name, $module = null)
    {
        $frontController = Zend_Controller_Front::getInstance();
        if (null === $module) {
            $module = $frontController->getDefaultModule();            
        }
        
        $applicationPath = Kajoa_Application::getInstance()->getApplicationPath(); 
        $modelPath       = $applicationPath . '/modules/' . $module . '/models';  
        
        self::loadClass($name, $modelPath);
    }
}