<?php
require_once 'Kajoa/Application.php';

class Kajoa_Controller_Action extends Zend_Controller_Action
{
    protected $_application;
    
    public function init()
    {
        parent::init();
        
        $moduleName = $this->getRequest()->getModuleName();
        $this->_helper->layout->setLayout($moduleName . '/views/layouts/main');
        
        $this->_application = Kajoa_Application::getInstance();
    }
}