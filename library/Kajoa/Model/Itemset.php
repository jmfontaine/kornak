<?php
require_once 'Kajoa/Loader.php';

class Kajoa_Model_Itemset implements SeekableIterator, Countable
{
    protected $_count;
    protected $_data      = array();
    protected $_itemClass = 'Kajoa_Model_Item';
    protected $_items     = array();
    protected $_model;
    protected $_pointer   = 0;
    
    public function __construct($model, array $config)
    {
        $this->_model = $model;
        
        if (isset($config['itemClass'])) {
            $this->_itemClass = $config['itemClass'];
        }
        @Kajoa_Loader::loadClass($this->_itemClass);
        if (isset($config['data'])) {
            $this->_data = $config['data'];
        }
        
        $this->_count = count($this->_data);
    }
    
    public function count()
    {
        return $this->_count;
    }
    
    public function current()
    {
        if ($this->valid() === false) {
            return null;
        }

        if (empty($this->_items[$this->_pointer])) {
            $this->_items[$this->_pointer] = new $this->_itemClass(
                $this->_model,
                array('data' => $this->_data[$this->_pointer])
            );
        }

        return $this->_items[$this->_pointer];
    }

    public function key()
    {
        return $this->_pointer;
    }

    public function next()
    {
        ++$this->_pointer;
    }

    public function rewind()
    {
        $this->_pointer = 0;
        return $this;
    }

    public function seek($position)
    {
        $position = (int) $position;
        if ($position < 0 || $position > $this->_count) {
            require_once 'Kajoa/Model/Itemset/Exception.php';
            throw new Kajoa_Model_Itemset_Exception("Illegal index $position");
        }
        $this->_pointer = $position;
        return $this;        
    }    
    
    public function toArray()
    {
        foreach ($this->_items as $i => $item) {
            $this->_data[$i] = $item->toArray();
        }
        return $this->_data;
    }

    public function valid()
    {
        return $this->_pointer < $this->_count;
    }
}