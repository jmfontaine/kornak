<?php
require_once 'Zend/View/Helper/Abstract.php';

class Kajoa_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    protected $_registry;

    public function __construct()
    {
        $this->_registry = Kajoa_View_Helper_Menu_Registry::getRegistry();
    }

    public function menu($name = 'default')
    {
        $name = (string) $name;
        return $this->_registry->getContainer($name);
    }

    public function getRegistry()
    {
        return $this->_registry;
    }
}
