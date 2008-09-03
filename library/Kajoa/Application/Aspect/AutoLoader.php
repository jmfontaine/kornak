<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Loader.php'; 

class Kajoa_Application_Aspect_AutoLoader extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'class' => 'Zend_Loader',
        ),
        'testing'     => array(),
        'development' => array(),
    );
    
    public function init()
    {
        $class = $this->getSetting('class');
        Zend_Loader::registerAutoload($class);
    }
}