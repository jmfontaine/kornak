<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Mail.php';

class Kajoa_Application_Aspect_Mail extends Kajoa_Application_Aspect_Abstract
{
    protected $_transports = array();

    protected $_defaultSettings = array(
        'production'  => array(),
        'testing'     => array(),
        'development' => array(),
    );
    
    protected function _loadTransport($name, Zend_Config $settings)
    {
        switch ($settings->type) {
            case 'sendmail' :
                require_once 'Zend/Mail/Transport/Sendmail.php';
                $transport = new Zend_Mail_Transport_Sendmail($settings->parameters);
                break;

            case 'smtp' :
                $config = array();
                if (isset($settings->config)) {
                    $config = $settings->config->toArray(); 
                }
                
                require_once 'Zend/Mail/Transport/Smtp.php';
                $transport = new Zend_Mail_Transport_Smtp($settings->host, $config);
                break;
                
            default:
                require_once 'Kajoa/Application/Aspect/Exception.php';
                throw new Kajoa_Application_Aspect_Exception("Unknown transport type ({$settings->type})");
        }
        
        if ($settings->isDefault) {
            Zend_Mail::setDefaultTransport($transport);            
        }
        
        $this->_transports[$name] = $transport;
    }
    
    public function getTransport($name = 'default')
    {
        if (!array_key_exists($name, $this->_transports)) {
            throw new Kajoa_Exception("Unknown transport ($name)");
        }
        
        return $this->_transports[$name];
    }
    
    public function init()
    {
        $settings = $this->getSettings();

        if (null == $settings->type) {
            foreach ($settings as $transportName => $transportSettings) {
                $this->_loadTransport($transportName, $transportSettings);
            }
        } else {
            $this->_loadTransport('default', $settings);
        }
    }
}