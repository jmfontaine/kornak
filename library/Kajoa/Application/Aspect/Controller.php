<?php
require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Controller/Front.php';

class Kajoa_Application_Aspect_Controller extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'routesUseLocales' => false,
            'routesFilePath'   => 'config/routes.ini',
            'throwException'   => false,
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

        if (true == $this->getSetting('routesUseLocales')) {
            foreach ($routesConfig as $locale => $routes) {
                // Handle hostname if present
                $hostnameRoute = null;
                if (isset($routes->hostname)) {
                    $route = new Zend_Controller_Router_Route_Static('/');
                    
                    $hostnameRoute = new Zend_Controller_Router_Route_Hostname(
                        $routes->hostname->route,
                        array('locale' => $locale)
                    );
                    $router->addRoute('full-' . $locale, $hostnameRoute->chain($route));
                    unset($routes->hostname);
                }
                
                foreach ($routes as $name => $values) {
                    $class = (isset($values->type)) ? $values->type : 'Zend_Controller_Router_Route';
                    Zend_Loader::loadClass($class);
    
                    $route = call_user_func(array($class, 'getInstance'), $values);
                    $router->addRoute($name . '-' . $locale, $route);
                    
                    if (null !== $hostnameRoute) {
                        $router->addRoute('full-' . $name . '-' . $locale, $hostnameRoute->chain($route));
                    }
                }
            }
        } else {
            $router->addConfig($routesConfig);
        }
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