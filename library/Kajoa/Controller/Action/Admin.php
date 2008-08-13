<?php
class Kajoa_Controller_Action_Admin extends Kajoa_Controller_Action
{
    protected function _checkAuth()
    {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_helper->redirector->gotoRoute(array('action' => 'login'),
                'adminAuth');
        }
    }

    public function init()
    {
        $this->getResponse()->setHeader('X-Powered-By', 'Kajoa', true);
        
        $this->_helper->layout->setLayout('admin/main');

        $this->view->headMeta()->appendName('Author', 'Kanopée');
        $this->view->headMeta()->appendName('Content-Type', 'text/html; charset=UTF-8');
        $this->view->headMeta()->appendName('Generator', 'Kajoa');
        $this->view->headMeta()->appendName('MSSmartTagsPreventParsing', 'true');
        $this->view->headMeta()->appendName('Robots', 'noindex,nofollow');
        
        $this->view->headTitle('Kajoa admin');

        $this->view->headLink()->appendStylesheet('/gui/admin/css/main.css');  
        $this->view->headLink()->appendStylesheet('/gui/admin/css/screen.css'); 

        $this->view->inlineScript()->appendFile('/data/javascript/jquery.js');
        $this->view->inlineScript()->appendFile('/data/javascript/jquery.pngfix.js');
        $this->view->inlineScript()->appendFile('/data/javascript/jquery.kajoa.js');
        $script = '$(document).ready(function(){
            $.kajoa.initAdminGui();
        });';
        $this->view->inlineScript()->appendScript($script); 
    }
    
    public function preDispatch()
    {
        parent::predispatch();
        $this->_checkAuth();
    }
}