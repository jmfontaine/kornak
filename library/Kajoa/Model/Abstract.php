<?php
require_once 'Kajoa/Loader.php';

abstract class Kajoa_Model_Abstract
{
    protected $_adapters     = array();
    protected $_itemClass    = 'Kajoa_Model_Item';
    protected $_itemsetClass = 'Kajoa_Model_Itemset';

    protected function _createItem($data)
    {
        if (empty($data)) {
            return false;
        }

        $config = array('data' => $data);
        Kajoa_Loader::loadClass($this->_itemClass);
        return new $this->_itemClass($this, $config);
    }

    protected function _createItemset($data)
    {
        $config = array('data' => $data);
        Kajoa_Loader::loadClass($this->_itemsetClass);
        return new $this->_itemsetClass($this, $config);
    }

    public function __construct()
    {
        $this->init();
    }

    public function getAdapter($name = 'default')
    {
        if (array_key_exists($name, $this->_adapters)) {
            return $this->_adapters[$name];
        } else {
            return false;
        }
    }

    public function init()
    {
    }

    public function setAdapter($adapter, $name = 'default')
    {
        $this->_adapters[$name] = $adapter;
    }
}