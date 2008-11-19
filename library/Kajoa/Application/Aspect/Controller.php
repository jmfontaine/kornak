<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Controller/Front.php';

class Kajoa_Application_Aspect_Controller extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'mapHostnameToLocale' => array(),
            'routesFilePath'      => 'config/routes.ini',
            'throwException'      => false,
        ),
        'testing'     => array(),
        'development' => array(
            'throwException' => true,
        ),
    );

    protected function _loadRoutes()
    {
        $frontController = Zend_Controller_Front::getInstance();

        $applicationPath = $this->getApplication()->getApplicationPath();
        $routesFilePath  = $applicationPath . '/' . $this->getSetting('routesFilePath');
        $routesConfig    = new Zend_Config_Ini($routesFilePath, null, true);
        $frontController->getRouter()->addConfig($routesConfig);

        // Map hostname to locale if needed
        $mapHostnameToLocale = $this->getSetting('mapHostnameToLocale')->toArray();
        if (!empty($mapHostnameToLocale)) {
            $frontController->registerPlugin(
                new Kajoa_Controller_Plugin_MapHostnameToLocale($mapHostnameToLocale)
            );
        }
    }

    public function init()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->throwExceptions($this->getSetting('throwException'));

        $applicationPath = $this->getApplication()->getApplicationPath();
        $frontController->addModuleDirectory($applicationPath . '/modules');

        $this->_loadRoutes();
    }

    public function run()
    {
        Zend_Controller_Front::getInstance()->dispatch();
    }
}