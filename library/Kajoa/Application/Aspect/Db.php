<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Db.php';
require_once 'Zend/Db/Table/Abstract.php';

class Kajoa_Application_Aspect_Db extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'connectionCharset' => '',
            'profilerClass'     => '', 
        ),
        'testing'     => array(),
        'development' => array(
            'profilerClass'     => 'Zend_Db_Profiler_Firebug', 
        ),
    );
    
    public function init()
    {
        $settings = $this->getSettings();

        $db = Zend_Db::factory($settings->adapter, $settings);
        
        if (!empty($settings->profilerClass)) {
            Zend_Loader::loadClass($settings->profilerClass);
            $profiler = new $settings->profilerClass('Database queries');
            $profiler->setEnabled(true);
            $db->setProfiler($profiler);
        }
        
        if (!empty($settings->connectionCharset)) {
            $db->query("SET NAMES '$settings->connectionCharset'");
        }
        
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }
}