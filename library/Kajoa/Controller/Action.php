<?php
class Kajoa_Controller_Action extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        
        $moduleName = $this->getRequest()->getModuleName();
        $this->_helper->layout->setLayout($moduleName . '/views/layouts/main');
    }
}