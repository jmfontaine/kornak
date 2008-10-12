<?php
class Kajoa_Model_Item
{
    protected $_data = array();
    
    public function __construct(array $config = array())
    {
        if (isset($config['data'])) {
            if (!is_array($config['data'])) {
                require_once 'Kajoa/Model/Item/Exception.php';
                throw new Kajoa_Model_Item_Exception('Data must be an array');
            }
            $this->_data = $config['data'];
        }
    }

    public function __get($name)
    {
        if (!array_key_exists($name, $this->_data)) {
            require_once 'Kajoa/Model/Item/Exception.php';
            throw new Kajoa_Model_Item_Exception("Specified property \"$name\" is not in the item");
        }
        return $this->_data[$name];
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->_data);
    }    

    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->_data)) {
            require_once 'Kajoa/Model/Item/Exception.php';
            throw new Kajoa_Model_Item_Exception("Specified property \"$name\" is not in the item");
        }
        $this->_data[$name] = $value;
    }
    
    public function toArray()
    {
        return (array)$this->_data;
    }
}