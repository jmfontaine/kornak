<?php
require_once 'Kajoa/Application/Bootstrap/Interface.php';

abstract class Kajoa_Application_Bootstrap_Abstract implements
    Kajoa_Application_Bootstrap_Interface
{
    const DEFAULT_KAJOA_PATH = '/usr/share/kajoa';
    
    protected $_applicationPath;
    protected $_kajoaPath;
    
    protected function _configureEnvironment()
    {
        $settings = Zend_Registry::get('settings');
            
        date_default_timezone_set($settings->misc->timezone);
    }
    
    protected function _dispatch()
    {
        Zend_Controller_Front::getInstance()->dispatch();
    }
    
    protected function _initialiseAuth()
    {
        $settings = Zend_Registry::get('settings');
        Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session($settings->misc->session_name));
    }
    
    protected function _initialiseDatabase()
    {
        $settings = Zend_Registry::get('settings');
        
        if (!empty($settings->db->adapter)) {
            $db = Zend_Db::factory($settings->db->adapter,
                                   $settings->db->config->toArray());
    
            // Set the conection charset to UTF-8
            if ($settings->db->compatibility->set_connection_charset) {
                $db->query('SET NAMES "utf8"');
            }
                                   
            Zend_Db_Table_Abstract::setDefaultAdapter($db);
        }
    }
    
    protected function _initialiseDatabaseMetadataCache()
    {
        $settings = Zend_Registry::get('settings');
        $debug    = (bool) $settings->misc->debug;
        
        if (!$debug) {
            $frontendOptions = array(
                'automatic_serialization' => true,
            );
            
            $backendOptions = array(
                'cache_dir' => $this->getTempPath() . '/database/metadata',
            );
            $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        } else {
            $cache = null;
        }
            
        Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
    }
        
    protected function _initialiseFrontController()
    {
        $frontController = Zend_Controller_Front::getInstance();
        
        $settings = Zend_Registry::get('settings');
        $frontController->throwExceptions((bool) $settings->misc->debug);
        
        if ($settings->misc->debug) {
            $path = $this->getLogsPath() . '/application/routerdebug.log';
            $plugin = new Kajoa_Controller_Plugin_RouterDebug(
                $path,
                Kajoa_Controller_Plugin_RouterDebug::WRITE_MODE_APPEND
            ); 
            $frontController->registerPlugin($plugin);
        }
        
        $applicationPath = $this->getApplicationPath();
        $frontController->addModuleDirectory($applicationPath . '/modules');
        $frontController->setDefaultModule('site');
        
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        $redirector->setCode(303);   
    }
    
    protected function _initialiseLayout()
    {
        $config = array(
            'layout'     => 'default',
            'contentKey' => 'content',
            'layoutPath' => $this->getLayoutsPath(),
            'viewSuffix' => 'tpl',
        );
        Zend_Layout::startMvc($config);
    }
    
    protected function _initialiseLogger()
    {
        $settings = Zend_Registry::get('settings');
    
        $logger = new Zend_Log();

        if ($settings->logger->writer->file) {
            $writer = new Zend_Log_Writer_Stream($this->getLogsPath() . '/application/application.log');
            
            $filter = new Zend_Log_Filter_Priority((int) $settings->logger->priority);
            $writer->addFilter($filter);

            $logger->addWriter($writer);
        }

        if ($settings->logger->writer->firephp) {
            $writer = new Kajoa_Log_Writer_FirePhp();
            
            $filter = new Zend_Log_Filter_Priority((int) $settings->logger->priority);
            $writer->addFilter($filter);

            $logger->addWriter($writer);
        }
        
        Zend_Registry::set('logger', $logger);
    }
    
    protected function _initialiseMail()
    {
        $settings = Zend_Registry::get('settings');
        
        if (!empty($settings->mail->smtp->host)) {
            $config = array(
                'auth'     => $settings->mail->smtp->auth,
                'password' => $settings->mail->smtp->password,
                'username' => $settings->mail->smtp->username,
            );
        
            $transport = new Zend_Mail_Transport_Smtp(
                $settings->mail->smtp->host,
                $config
            );
            Zend_Mail::setDefaultTransport($transport);
        }    
    }    
    
    protected function _initialiseRoutes()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();

        $route = new Zend_Controller_Router_Route(
            'admin/:controller/list/:page',
            array(
                'module'     => 'admin',
                'controller' => 'index',
                'action'     => 'list',
                'page'       => 1,
            ),
            array(
                'page' => '\d+',
            )
        );
        $router->addRoute('adminList', $route);
        
        $route = new Zend_Controller_Router_Route(
            'admin/:controller/add',
            array(
                'module'     => 'admin',
                'controller' => 'index',
                'action'     => 'edit',
            )
        );
        $router->addRoute('adminAdd', $route);
        
        $route = new Zend_Controller_Router_Route(
            'admin/:controller/edit/:id',
            array(
                'module'     => 'admin',
                'controller' => 'index',
                'action'     => 'edit',
                'id'         => null,
            )
        );
        $router->addRoute('adminEdit', $route);
        
        $route = new Zend_Controller_Router_Route(
            'admin/:controller/delete/:id',
            array(
                'module'     => 'admin',
                'controller' => 'index',
                'action'     => 'delete',
                'id'         => null,
            )
        );
        $router->addRoute('adminDelete', $route);
        
        $route = new Zend_Controller_Router_Route(
            'admin/auth/:action',
            array(
                'module'     => 'admin',
                'controller' => 'auth',
                'action'     => 'login',
            )
        );
        $router->addRoute('adminAuth', $route);
        
        // Load custom routes
        $configPath = $this->getConfigPath();
        $routes     = new Zend_Config_Ini($configPath . '/routes.ini', null);
        $router->addConfig($routes, 'routes');
    }
        
    protected function _initialiseSessions()
    {
        Zend_Session::start();
    }
    
    protected function _initialiseView()
    {
        $view = new Kajoa_View_Smarty(
            array(
                'compile_dir'     => $this->getTempPath() . '/views',
                'php_handling'    => SMARTY_PHP_REMOVE,
                'plugins_dir'     => array(
                                        'Smarty/plugins',
                                        'Kajoa/View/Smarty/Helpers/',
                                     ),
                'error_reporting' => E_ALL,
                'use_sub_dirs'    => true, 
            )
        );
        $viewHelpersPath = $this->getKajoaLibraryPath() . '/Kajoa/View/Helper';
        $view->addHelperPath($viewHelpersPath, 'Kajoa_View_Helper');
        
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        $viewRenderer->setViewSuffix('tpl');  
        $viewRenderer->view->doctype('HTML4_STRICT');      
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        
        $view->addHelperPath($this->getKajoaLibraryPath() . '/Kajoa/View/Helper', 'Kajoa_View_Helper');        
    }
    
    protected function _loadSettings()
    {
        $options           = array('allowModifications' => true);
        $defaultConfigPath = $this->getKajoaPath() . '/data/config';
        $settings          = new Zend_Config_Ini($defaultConfigPath . '/settings.ini', null, $options);
    
        $configPath = $this->getConfigPath();
        $settings->merge(new Zend_Config_Ini($configPath . '/settings.ini', null));
        
        Zend_Registry::set('settings', $settings);
    }
    
    protected function _registerAutoload()
    {
        require_once 'Zend/Loader.php';
        Zend_Loader::registerAutoload('Kajoa_Loader');
    }
    
    protected function _setApplicationPath($path = null)
    {
        if (empty($path)) {
            $path = realpath(getcwd() . '/..');
        }
        $this->_applicationPath = $path;
    }
    
    protected function _setErrorLevel()
    {
        error_reporting(E_ALL|E_STRICT);    
    }
    
    protected function _setIncludePath()
    {
        $includePath = explode(PATH_SEPARATOR, get_include_path());
        array_unshift($includePath, $this->getKajoaPath() . '/library');
        array_unshift($includePath, $this->getKajoaPath() . '/library/HtmlPurifier');
        array_unshift($includePath, $this->getKajoaPath() . '/library/ZymIncubator');
        array_unshift($includePath, $this->getApplicationLibraryPath());
        $includePath = array_unique($includePath);
        
        set_include_path(implode(PATH_SEPARATOR, $includePath));
    }
    
    protected function _setKajoaPath()
    {
        $kajoaPath = $this->getApplicationPath() . '/kajoa';
        if (is_readable($kajoaPath) && is_dir($kajoaPath)) {
            $this->_kajoaPath = $kajoaPath;
            return;    
        }
    
        $kajoaPath = self::DEFAULT_KAJOA_PATH; 
        if (is_readable($kajoaPath) && is_dir($kajoaPath)) {
            $this->_kajoaPath = $kajoaPath;
            return;    
        }
        
        throw new Exception('Unable to find Kajoa');
    }

    public function doInitialiseForCli($applicationPath = null)
    {
        $this->_setErrorLevel();
        $this->_setApplicationPath($applicationPath);
        $this->_setKajoaPath();
        $this->_setIncludePath();
        $this->_registerAutoload();
        $this->_loadSettings();
        $this->_initialiseSessions();
        $this->_initialiseAuth();
        $this->_initialiseLogger();
        $this->_configureEnvironment();
        $this->_initialiseDatabase();
        $this->_initialiseDatabaseMetadataCache();
        $this->_initialiseMail();
    }
        
    public function doRun()
    {
        $this->_setErrorLevel();
        $this->_setApplicationPath();
        $this->_setKajoaPath();
        $this->_setIncludePath();
        $this->_registerAutoload();
        $this->_loadSettings();
        $this->_initialiseSessions();
        $this->_initialiseAuth();
        $this->_initialiseLogger();
        $this->_configureEnvironment();
        $this->_initialiseRoutes();
        $this->_initialiseFrontController();
        $this->_initialiseLayout();
        $this->_initialiseView();
        $this->_initialiseDatabase();
        $this->_initialiseDatabaseMetadataCache();
        $this->_initialiseMail();
        $this->_dispatch();
    }
    
    public function getApplicationLibraryPath()
    {
        return $this->_applicationPath . '/library';
    }
    
    public function getApplicationPath()
    {
        return $this->_applicationPath;
    }
    
    public function getConfigPath()
    {
        return $this->_applicationPath . '/config';
    }
    
    public function getFormsPath()
    {
        return $this->_applicationPath . '/forms';
    }
    
    public function getLayoutsPath()
    {
        return $this->_applicationPath . '/layouts';
    }
    
    public function getLogsPath()
    {
        return $this->_applicationPath . '/logs';
    }

    public function getKajoaPath()
    {
        return $this->_kajoaPath;
    }
    
    public function getKajoaLibraryPath()
    {
        return $this->_kajoaPath . '/library';
    }
    
    public function getModelsPath()
    {
        return $this->getApplicationPath() . '/models';
    }
    
    public function getModulesPath()
    {
        return $this->getApplicationPath() . '/modules';
    }
    
    public function getPublicPath()
    {
        $settings = Zend_Registry::get('settings');
        
        return $this->_applicationPath . '/' . $settings->misc->public_directory;
    }
    
    public function getTempPath()
    {
        return $this->_applicationPath . '/temp';
    }
}