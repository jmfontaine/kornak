<?php
require_once 'Zend/Config/Ini.php';
require_once 'Zend/Filter/Word/DashToCamelCase.php';
require_once 'Zend/Loader.php';

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
                'config'      => '../config',
                'data'        => '../data',
                'public'      => '../public',
                'root'        => '../',
                'temp'        => '../temp',
            ),
        ),
        'testing' => array(),
        'development' => array(),
    );
    protected $_environment = self::ENVIRONMENT_PRODUCTION;
    protected $_settings;

    public function _getDefaultApplicationSettings($environment)
    {
        $defaultSettings = $this->_defaultApplicationSettings[$environment];
        
        if (self::ENVIRONMENT_PRODUCTION != $environment) {
            $productionDefaultSettings = $this->_defaultApplicationSettings[self::ENVIRONMENT_PRODUCTION];
            $defaultSettings = array_merge($productionDefaultSettings, $defaultSettings); 
        }
        
        return $defaultSettings;
    }
    
    public function _getDefaultAspects($environment)
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
        $environment = $this->getEnvironment();
        $filter      = new Zend_Filter_Word_DashToCamelCase();

        $aspects = explode(',', $settings->order);
        foreach($aspects as $name) {
            $filteredName = $filter->filter(trim($name));
            $class = 'Kajoa_Application_Aspect_' . $filteredName;
            Zend_Loader::loadClass($class);
            
            $aspectSettings = null;
            if (isset($settings->$name)) {
                $aspectSettings = $settings->$name;
            }
            
            $this->_aspects[$name] = new $class($aspectSettings, $environment);
        }
    }
    
    public function dispatch()
    {
        foreach ($this->_aspects as $aspect) {
            $aspect->init();
        }
    }
    
    public function getApplicationPath()
    {
        return $this->_applicationSettings->path->application;
    }

    public function getConfigPath()
    {
        return $this->_applicationSettings->path->config;
    }
    
    public function getDataPath()
    {
        return $this->_applicationSettings->path->data;
    }
    
    public function getEnvironment()
    {
        return $this->_environment;
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
    
    public function getSettings()
    {
        return $this->_settings;
    }
    
    public function getTempPath()
    {
        return $this->_applicationSettings->path->temp;
    }
    
    public function loadSettings($filepath)
    {
        $this->_settings = new Zend_Config_Ini($filepath, null, true);
        
        $environment = $this->getEnvironment();
        
        $this->_loadApplicationSettings($this->_getSettingsKey('application', $environment));
        $this->_loadAspects($this->_getSettingsKey('aspects', $environment));

        return $this;
    }
    
    public static function run($settings = '../config/settings.ini',
        $environment = self::ENVIRONMENT_PRODUCTION)
    {
        $instance = self::getInstance();
        $instance->setEnvironment($environment);
        $instance->loadSettings($settings);
        $instance->dispatch();
    }
    
    public function setEnvironment($environment)
    {
        $this->_environment = $environment;

        return $this;
    }
}