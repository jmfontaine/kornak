<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Controller/Front.php';

class Kajoa_Application_Aspect_Controller extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'mapHostnameToLocale' => false,
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

        // KLUDGE: Workaround a Zend Framework bug
        $request = new Zend_Controller_Request_Http();
        $frontController->setRequest($request);

        $frontController->throwExceptions($this->getSetting('throwException'));

        $router = $frontController->getRouter();

        $applicationPath = $this->getApplication()->getApplicationPath();
        $routesFilePath  = $applicationPath . '/' . $this->getSetting('routesFilePath');
        $routesConfig    = new Zend_Config_Ini($routesFilePath, null, true);

        // Map hostname to locale if needed
        if (true == $this->getSetting('mapHostnameToLocale')) {
            foreach ($routesConfig as $locale => $hostname) {
                foreach ($hostname->chains as $route) {
                    $defaults = $route->defaults;
                    $defaults->locale = $locale;
                }
            }
        }

        $router->addConfig($routesConfig);
    }

    public function init()
    {
        $applicationPath = $this->getApplication()->getApplicationPath();

        $this->_loadRoutes();

        $frontController = Zend_Controller_Front::getInstance();
        $frontController->addModuleDirectory($applicationPath . '/modules');
    }

    public function run()
    {
        Zend_Controller_Front::getInstance()->dispatch();
    }
}