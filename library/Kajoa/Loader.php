<?php
class Kaoja_Loader extends Zend_Loader
{
    public static function autoload($class)
    {
        try {
            try {
                // KLUDGE : Workaround for bug #ZF-2923
                // Suppress PHP warnings while loading to avoid
                // warnings if file is not found in the loadFile() method.
                $oldErrorReporting = error_reporting();
                error_reporting($oldErrorReporting ^ E_WARNING);
                
                if ('Form' == substr($class, -4)) {
                    self::loadForm($class);
                } elseif ('Model' == substr($class, -5)) {
                    self::loadModel($class);
                } elseif ('Model_Table' == substr($class, -11)) {
                    self::loadModelTable($class);
                } else {
                    self::loadClass($class);
                }

                error_reporting($oldErrorReporting);
                return $class;
            } catch (Exception $exception) {
                error_reporting($oldErrorReporting ^ E_WARNING);
                self::loadClass($class);
                error_reporting($oldErrorReporting);
                return $class;
            }
        } catch (Exception $exception) {
            error_reporting($oldErrorReporting);
            return false;
        }
    }
    
    public static function loadForm($class, $dirs = array())
    {
        $modulesPath = Application_Bootstrap::getInstance()->getModulesPath();
        $module      = strtolower(substr($class, 0, strpos($class, '_')));
        $dirs[]      = $modulesPath . '/' . $module . '/forms';
            
        $class = substr($class, strpos($class, '_') + 1);
        self::loadClass($class, $dirs);
    }

    public static function loadModel($class, $dirs = array())
    {
        $dirs[] = Application_Bootstrap::getInstance()->getModelsPath();
        
        self::loadClass($class, $dirs);
    }

    public static function loadModelTable($class, $dirs = array())
    {
        // Remove the trailing "_Table"
        $modelClass = substr($class, 0, -6);
        
        $dirs[] = Application_Bootstrap::getInstance()->getModelsPath();
        
        self::loadClass($class, $dirs);
    }
}