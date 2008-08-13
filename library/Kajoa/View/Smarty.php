<?php
require_once 'Smarty/Smarty.class.php';

class Kajoa_View_Smarty extends Zend_View_Abstract
{
    protected $_smarty;

    public function __construct($config = array())
    {
        $this->_smarty = new Smarty();

        if (!array_key_exists('compile_dir', $config)) {
            throw new Exception('compileDir must be set in $config for ' . 
                get_class($this));
        }

        foreach ($config as $name => $value) {
            $this->_smarty->$name = $value;
        }
        
        parent::__construct($config);
    }

    public function getEngine()
    {
        return $this->_smarty;
    }

    protected function _run()
    {
        $this->strictVars(true);

        // Assign values to the template
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if ('_' != substr($key, 0, 1)) {
                $this->_smarty->assign($key, $value);
            }
        }

        // To emulate standard Zend_View functionality
        $this->_smarty->assign_by_ref('this', $this);

        // Smarty needs a template_dir, and can only use templates,
        // so we need to find the path where the script is
        $script     = func_get_arg(0);
        $scriptPath = '';
        $paths      = $this->getScriptPaths();
        foreach ($paths as $path) {
            $subString = substr($scriptPath, 0, strlen($path));
            if ($path == $subString) {
                $scriptPath = $subString; 
            }
        }
        $this->_smarty->template_dir = $scriptPath;
        $file = substr($script, strlen($scriptPath));

        // Use the path as a compile_id to avoid conflicts
        echo $this->_smarty->fetch($file, null, $scriptPath);
    }
}