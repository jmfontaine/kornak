<?php
/**
 * Kornak
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.kornak-framework.org/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@kornak-framework.org so we can send you a copy immediately.
 *
 * @category   Kornak
 * @package    Kornak_Application
 * @copyright  Copyright (c) 2008-2009 Kornak Group (http://www.kornak-framework.org/)
 * @version    $Id$
 */

require_once 'Kornak/Exception.php';

/**
 * @deprecated Deprecated since version 0.2
 */
abstract class Kornak_Application_Aspect_Abstract
{
    protected $_application;
    protected $_defaultSettings = array(
        'production'  => array(),
        'testing'     => array(),
        'development' => array(),
    );
    protected $_environment;
    protected $_settings;

    public function __construct($settings, $environment, $application)
    {
        $this->setEnvironment($environment);
        $this->setSettings($settings);
        $this->setApplication($application);
    }

    public function getApplication()
    {
        return $this->_application;
    }

    public function getSetting($name)
    {
        if (!isset($this->_settings->$name)) {
            throw new Kornak_Exception("Unknown setting '$name'");
        }

        return $this->_settings->$name;
    }

    public function getSettings()
    {
        return $this->_settings;
    }

    public function getDefaultSettings($environment)
    {
        $defaultSettings = $this->_defaultSettings[$environment];

        if (Kornak_Application::ENVIRONMENT_PRODUCTION != $environment) {
            $productionDefaultSettings = $this->_defaultSettings[Kornak_Application::ENVIRONMENT_PRODUCTION];
            $defaultSettings = array_merge($productionDefaultSettings, $defaultSettings);
        }

        return new Zend_Config($defaultSettings, true);
    }

    public function getEnvironment()
    {
        return $this->_environment;
    }

    public function init()
    {

    }

    public function run()
    {

    }

    public function setApplication($application)
    {
        $this->_application = $application;
    }

    public function setSettings($settings)
    {
        $environment   = $this->getEnvironment();
        $defaultSettings = $this->getDefaultSettings($environment);

        if (null == $settings) {
            $this->_settings = $defaultSettings;
        } else {
            $this->_settings = $defaultSettings->merge($settings);
        }
    }

    public function setEnvironment($environment)
    {
        $this->_environment = $environment;
    }
}