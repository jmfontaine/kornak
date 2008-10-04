<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/View.php';

class Kajoa_Application_Aspect_View extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(),
        'testing'     => array(),
        'development' => array(),
    );
    
    public function init()
    {
        $view = new Zend_View();
        $view->setHelperPath('Kajoa/View/Helper/', 'Kajoa_View_Helper_');        
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->setView($view);
    }    
}