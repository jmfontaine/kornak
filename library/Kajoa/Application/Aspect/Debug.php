<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';

class Kajoa_Application_Aspect_Debug extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'logPhpErrors' => false,
        ),
        'testing'     => array(),
        'development' => array(
            'logPhpErrors' => true,
        ),
    );
    
    protected $_phpErrors;
    
    public function init()
    {
        $settings = $this->getSettings();
        
        if ($settings->logPhpErrors) {
            set_error_handler(array($this, 'logPhpError'), error_reporting());
            
            require_once 'Zend/Wildfire/Plugin/FirePhp/TableMessage.php';
            $this->_phpErrors = new Zend_Wildfire_Plugin_FirePhp_TableMessage('PHP errors');
            $this->_phpErrors->setBuffered(true);
            $this->_phpErrors->setHeader(array('Code', 'Message', 'File', 'Line'));
            $this->_phpErrors->setDestroy(true);

            require_once 'Zend/Wildfire/Plugin/FirePhp.php';
            Zend_Wildfire_Plugin_FirePhp::getInstance()->send($this->_phpErrors);
        }        
    }
    
    public function logPhpError($code, $message, $file, $line, $context)
    {
        switch ($code) {
            case E_USER_ERROR:
                $code = 'Error';
                break;
                
            case E_WARNING:
            case E_USER_WARNING:
                $code = 'Warning';
                break;

            case E_NOTICE:
            case E_USER_NOTICE:
                $code = 'Notice';
                break;
            
            default:
                require_once 'Kajoa/Application/Aspect/Exception.php';
                throw new Kajoa_Application_Aspect_Exception("Unhandled error code '$code'");
        }
        
        $this->_phpErrors->setDestroy(false);
        $this->_phpErrors->addRow(array($code, $message, $file, $line));
        
        // Let the error continue its way through PHP
        return false;
    }
}