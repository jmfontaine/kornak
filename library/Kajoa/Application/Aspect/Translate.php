<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Translate.php';

class Kajoa_Application_Aspect_Translate extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'adapter'  => 'gettext',
            'scanMode' => Zend_Translate::LOCALE_FILENAME,
        ),
        'testing'     => array(),
        'development' => array(),
    );
    
    public function init()
    {
        $dataPath         = $this->getApplication()->getDataPath();
        $translationsPath = $dataPath . '/translations'; 
        
        $adapter   = $this->getSetting('adapter');
        $options   = array('scan' => $this->getSetting('scanMode'));
        $translate = new Zend_Translate($adapter, $translationsPath, null, $options);
        Zend_Registry::set('Zend_Translate', $translate);
    }    
}