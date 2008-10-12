<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Db.php';
require_once 'Zend/Db/Table/Abstract.php';

class Kajoa_Application_Aspect_Db extends Kajoa_Application_Aspect_Abstract
{
    protected $_connections = array();

    protected $_defaultSettings = array(
        'production'  => array(),
        'testing'     => array(),
        'development' => array(),
    );
    
    protected function _loadConnection($name, Zend_Config $settings)
    {
        $connection = Zend_Db::factory($settings->adapter, $settings);
        
        if ($settings->profiler) {
            if (!empty($settings->profilerClass)) {
                $profilerClass = $settings->profilerClass;
            } else {
                $profilerClass = 'Zend_Db_Profiler_Firebug';                
            }
            Zend_Loader::loadClass($profilerClass);
            $profiler = new $profilerClass('Database queries');
            $profiler->setEnabled(true);
            $connection->setProfiler($profiler);
        }
        
        if (!empty($settings->connectionCharset)) {
            $connection->query("SET NAMES '$settings->connectionCharset'");
        }
        
        if ($settings->isDefault) {
            Zend_Db_Table_Abstract::setDefaultAdapter($connection);            
        }
        
        $this->_connections[$name] = $connection;
    }
    
    public function getConnection($name = 'default')
    {
        if (!array_key_exists($name, $this->_connections)) {
            throw new Kajoa_Exception("Unknown connection ($name)");
        }
        
        return $this->_connections[$name];
    }
    
    public function init()
    {
        $settings = $this->getSettings();

        if (null == $settings->adapter) {
            foreach ($settings as $connectionName => $connectionSettings) {
                $this->_loadConnection($connectionName, $connectionSettings);
            }
        } else {
            $this->_loadConnection('default', $settings);
        }
    }
}