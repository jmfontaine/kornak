<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Db.php';
require_once 'Zend/Db/Table/Abstract.php';

class Kajoa_Application_Aspect_Db extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'connectionCharset' => '', 
        ),
        'testing'     => array(),
        'development' => array(),
    );
    
    public function init()
    {
        $settings = $this->getSettings();

        $adapter = $settings->adapter;
        unset($settings->adapter);
        
        $db = Zend_Db::factory($adapter, $settings);
        
        $connectionCharset = $this->getSetting('connectionCharset');
        if (!empty($connectionCharset)) {
            $db->query("SET NAMES '$connectionCharset'");
        }
        
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }
}