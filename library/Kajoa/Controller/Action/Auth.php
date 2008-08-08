<?php
class Kajoa_Controller_Action_Auth extends Kajoa_Controller_Action_Admin
{
    public function indexAction()
    {
        $this->_helper->redirector->gotoRoute(array('action' => 'login'), 'adminAuth');
    }

    public function init()
    {
        parent::init();
        $this->_helper->layout->setLayout('admin/login');
    }
    
    public function loginAction()
    {
        $this->view->inlineScript()->appendFile('/data/javascript/jquery.js');
        $script = '$(document).ready(function(){
            $("#email").focus();
        });';
        $this->view->inlineScript()->appendScript($script);
        
        $form = new Admin_LoginForm();        
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost() && $form->isValid($_POST)) {
            try {
                $values = $form->getValues();
                $hashedPassword = Kajoa_Crypt::hash($values['password']);
                
                $dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
                
                $auth        = Zend_Auth::getInstance();
                $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
                $authAdapter->setTableName('users')
                            ->setIdentityColumn('email')
                            ->setCredentialColumn('password')       
                            ->setIdentity($values['email'])
                            ->setCredential($hashedPassword);
                $result = $auth->authenticate($authAdapter);
                
                if ($result->isValid()) {
                    $data = $authAdapter->getResultRowObject(null, 'password');
                    $auth->getStorage()->write($data);
                        
                    $this->_helper->redirector->goto('index', 'index', 'admin');
                } else {
                    throw new Kajoa_Form_Exception_LoginFailed();
                }
            } catch(Exception $exception) {
                $form->addFormError('Login failed');
            }
        }
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector->gotoRoute(array('action' => 'login'), 'adminAuth');
    }

    public function preDispatch()
    {
        // Do nothing to prevent circular redirection
    }
}