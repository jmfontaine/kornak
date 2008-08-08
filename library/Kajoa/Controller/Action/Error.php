<?php
class Kajoa_Controller_Action_Error extends Kajoa_Controller_Action
{
    public function errorAction()
    {
        $errorHandler = $this->getRequest()->get('error_handler');

        switch ($errorHandler->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $code = 404;
                break;
            default:
                $code = 500;
                break;
        }
        $this->_response->setHttpResponseCode($code);

        $this->_response->clearBody();        
        $this->_helper->layout->setLayout('site/error');
        $this->view->code    = $code;
        $this->view->message = $errorHandler->exception->getMessage();
    }
}