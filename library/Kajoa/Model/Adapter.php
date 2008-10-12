<?php
require_once 'Kajoa/Loader.php';
require_once 'Zend/Filter/Word/DashToCamelCase.php';

class Kajoa_Model_Adapter
{
    public static function factory($name, $options = array())
    {
        $filter = new Zend_Filter_Word_DashToCamelCase();
        $class  = 'Kajoa_Model_Adapter_' . $filter->filter($name);
        Kajoa_Loader::loadClass($class);
        return new $class($options);
    }
}