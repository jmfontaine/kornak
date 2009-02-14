<?php
/**
 * Kajoa
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.kajoa.org/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@kajoa.org so we can send you a copy immediately.
 *
 * @category   Kajoa
 * @package    Kajoa_Application
 * @copyright  Copyright (c) 2008-2009 Kajoa Group (http://www.kajoa.org/)
 * @version    $Id$
 */

require_once 'Kajoa/Application/Aspect/Abstract.php';
require_once 'Zend/Controller/Action/HelperBroker.php';
require_once 'Zend/Controller/Front.php';

class Kajoa_Application_Aspect_Controller extends Kajoa_Application_Aspect_Abstract
{
    protected $_defaultSettings = array(
        'production'  => array(
            'mapHostnameToLocale' => array(),
            'plugins'             => array(),
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

        Zend_Controller_Action_HelperBroker::addPrefix('Kajoa_Controller_Action_Helper_');

        $plugins = $this->getSetting('plugins');
        foreach ($plugins as $class => $config) {
            Zend_Loader::loadClass($class);
            $plugin = new $class();
            if ($config instanceof Zend_Config) {
                $plugin->setOptions($config->toArray());
            }
            $frontController->registerPlugin($plugin);
        }
    }

    public function run()
    {
        Zend_Controller_Front::getInstance()->dispatch();
    }
}