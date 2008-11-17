<?php
require_once 'Zend/Config/Ini.php';
require_once 'Zend/Filter/Word/DashToCamelCase.php';
require_once 'Zend/Loader/PluginLoader.php';

class Kajoa_Application
{
    const ENVIRONMENT_DEVELOPMENT = 'development';
    const ENVIRONMENT_TESTING     = 'testing';
    const ENVIRONMENT_PRODUCTION  = 'production';

    protected $_applicationSettings;
    protected $_aspects = array();
    protected $_defaultAspects = array(
        'production' => array(
            'php',
            'controller',
        ),
        'testing' => array(),
        'development' => array(),
    );
    protected $_defaultApplicationSettings = array(
        'production' => array(
            'path'    => array(
                'application' => '../application',
                'config'      => '../application/config',
                'data'        => '../data',
                'library'     => '../library',
                'public'      => '../public',
                'root'        => '../',
                'temp'        => '../temp',
            ),
        ),
        'testing' => array(),
        'development' => array(),
    );
    protected $_environment;
    protected $_settings;
    protected $_shellClass;

    protected function _getDefaultApplicationSettings($environment)
    {
        $defaultSettings = $this->_defaultApplicationSettings[$environment];

        if (self::ENVIRONMENT_PRODUCTION != $environment) {
            $productionDefaultSettings = $this->_defaultApplicationSettings[self::ENVIRONMENT_PRODUCTION];
            $defaultSettings = array_merge($productionDefaultSettings, $defaultSettings);
        }

        return $defaultSettings;
    }

    protected function _getDefaultAspects($environment)
    {
        $defaultAspects = $this->_defaultAspects[$environment];

        if (self::ENVIRONMENT_PRODUCTION != $environment) {
            $productionDefaultAspects = $this->_defaultAspects[self::ENVIRONMENT_PRODUCTION];
            $defaultAspects = array_merge($productionDefaultAspects, $defaultAspects);
        }

        return $defaultAspects;
    }

    protected function _getSettingsKey($key, $environment)
    {
        $productionKeyParts = explode('.', $key);
        array_unshift($productionKeyParts, 'production');
        $productionSettings = $this->_getSettingsKeyFromParts($productionKeyParts);

        $environmentSettings = null;
        if (self::ENVIRONMENT_PRODUCTION != $environment) {
            $environmentKeyParts = explode('.', $key);
            array_unshift($environmentKeyParts, $environment);
            $environmentSettings = $this->_getSettingsKeyFromParts($environmentKeyParts);
        }

        $settings = new Zend_Config(array(), true);
        if (null !== $productionSettings) {
            $settings->merge($productionSettings);
        }
        if (null !== $environmentSettings) {
            $settings->merge($environmentSettings);
        }

        return $settings;
    }

    protected function _getSettingsKeyFromParts($parts)
    {
        $currentLevel = $this->_settings;

        foreach ($parts as $part) {
            $nextLevel = $currentLevel->get($part);
            if (null === $nextLevel) {
                return null;
            }
            $currentLevel = $nextLevel;
        }

        return $nextLevel;
    }

    protected function _loadApplicationSettings($settings)
    {
        $environment = $this->getEnvironment();

        $applicationSettings = new Zend_Config($this->_getDefaultApplicationSettings($environment), true);
        if ($settings instanceof Zend_Config) {
            $applicationSettings = $applicationSettings->merge($settings);
        }
        $this->_applicationSettings = $applicationSettings;
    }

    protected function _loadAspects($settings)
    {
        $loader = new Zend_Loader_PluginLoader();
        $loader->addPrefixPath('Kajoa_Application_Aspect_', 'Kajoa/Application/Aspect/');
        $loader->addPrefixPath('Application_Aspect_', $this->getApplicationPath() . '/aspects/');

        $environment = $this->getEnvironment();
        $filter      = new Zend_Filter_Word_DashToCamelCase();

        $aspects = explode(',', $settings->order);
        foreach($aspects as $name) {
            $className = $loader->load($name);

            $aspectSettings = null;
            if (isset($settings->$name)) {
                $aspectSettings = $settings->$name;
            }

            $this->_aspects[$name] = new $className($aspectSettings, $environment, $this);
        }
    }

    public function dispatch()
    {
        foreach ($this->_aspects as $aspect) {
            $aspect->init();
        }

        foreach ($this->_aspects as $aspect) {
            $aspect->run();
        }
    }

    public function getApplicationPath()
    {
        return $this->_applicationSettings->path->application;
    }

    public function getAspect($name)
    {
        if (array_key_exists($name, $this->_aspects)) {
            return $this->_aspects[$name];
        } else {
            return false;
        }
    }

    public function getConfigPath()
    {
        return $this->_applicationSettings->path->config;
    }

    public function getDataPath()
    {
        return $this->_applicationSettings->path->data;
    }

    public function getLibraryPath()
    {
        return $this->_applicationSettings->path->library;
    }

    public function getEnvironment()
    {
        // Look for manually defined environment
        if (!empty($this->_environment)) {
            return $this->_environment;
        }

        // Look for environment defined in a system environment variable
        $environment = getenv('KAJOA_ENV');
        if(false !== $environment) {
            return $environment;
        }

        // Default to "production" environment
        return self::ENVIRONMENT_PRODUCTION;
    }

    public function getRootPath()
    {
        return $this->_applicationSettings->path->root;
    }

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }
        return $instance;
    }

    public function getPublicPath()
    {
        return $this->_applicationSettings->path->public;
    }

    public function getSetting($name)
    {
        $setting = null;

        if (isset($this->_settings->production->application->$name)) {
            $setting = $this->_settings->production->application->$name;
        }

        $environment = $this->getEnvironment();
        if (isset($this->_settings->environment->application->$name)) {
            $setting = $this->_settings->environment->application->$name;
        }

        if (null === $setting) {
            throw new Kajoa_Exception("Unknown setting '$name'");
        }

        return $setting;
    }

    public function getSettings()
    {
        return $this->_settings;
    }

    public function getShellClass()
    {
        return $this->_shellClass;
    }

    public function getTempPath()
    {
        return $this->_applicationSettings->path->temp;
    }

    public function hasAspect($name)
    {
        return array_key_exists($name, $this->_aspects);
    }

    public function loadSettings($filepath)
    {
        $this->_settings = new Zend_Config_Ini($filepath, null, true);

        $environment = $this->getEnvironment();

        $this->_loadApplicationSettings($this->_getSettingsKey('application', $environment));
        $this->_loadAspects($this->_getSettingsKey('aspects', $environment));

        return $this;
    }

    public static function run($settings = null,
        $environment = null)
    {
        if (null === $settings) {
            $settings = '../application/config/settings.ini';
        }

        $instance = self::getInstance();
        $instance->setEnvironment($environment);
        $instance->loadSettings($settings);

        set_include_path($instance->getLibraryPath() . PATH_SEPARATOR . get_include_path());

        $instance->dispatch();
    }

    public static function runShell($shellClass, $settings = null,
        $environment = self::ENVIRONMENT_PRODUCTION)
    {
        if (null === $settings) {
            $settings = './config/settings.ini';
        }

        self::run($settings, $environment);

        self::getInstance()->setShellClass($shellClass);
        call_user_func(array($shellClass, 'run'));
    }

    public function setEnvironment($environment)
    {
        $this->_environment = $environment;

        return $this;
    }

    public function setShellClass($class)
    {
        $this->_shellClass = $class;
    }
}