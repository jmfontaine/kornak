<?php
require_once 'Kajoa/Loader.php';

class Kajoa_View_Helper_Model extends Zend_View_Helper_Abstract
{
    public function model($name, $module = null)
    {
        Kajoa_Loader::loadModel($name, $module);

        $class = $name . 'Model';
        return new $class();
    }
}