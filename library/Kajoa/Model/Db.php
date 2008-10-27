<?php
require_once 'Kajoa/Model/Abstract.php';

class Kajoa_Model_Db extends Kajoa_Model_Abstract
{
    protected $_options = array();
    
    protected function _createItem($data)
    {
        if (is_object($data)) {
            $data = $data->toArray();
        }
        return parent::_createItem($data->toArray());
    }
    
    protected function _createItemset($data)
    {
        if (is_object($data)) {
            $data = $data->toArray();
        }
        return parent::_createItemset($data);
    }
    
    public function __construct()
    {
        $adapter = Kajoa_Model_Adapter::factory('db-table', $this->_options);
        $this->setAdapter($adapter);
        
        parent::__construct();
    }
    
    public function add(array $data)
    {
        return $this->getAdapter()->insert($data);
    }
    
    public function getAll(Kajoa_Model_Conditions $conditions = null,
        $fields = '*', $orderBy = null, $limit = null)
    {
        $select = $this->getAdapter()->select();
        
        if (null !== $conditions) {
            $select->where($conditions);
        }
        
        if (null !== $orderBy) {
            $select->order($orderBy);
        }
        
        if (null !== $limit) {
            $select->limit($limit);
        }
        
        
        $data = $this->getAdapter()->fetchAll($select);
        if (false !== $data) {
            $data = $this->_createItemset($data);
        }
        return $data;
    }
    
    public function getById($id)
    {
        $data = $this->getAdapter()->find($id)->current();
        if (false !== $data) {
            $data = $this->_createItem($data);
        }
        return $data;
    }
    
    public function getOption($name)
    {
        if (array_key_exists($name, $this->_options)) {
            return $this->_options[$name];
        }
        
        return false;
    }
    
    public function getTable()
    {
        return $this->getAdapter()->getAdapter();        
    }
    
    public function getTableName()
    {
        $this->getOption('name');
    }
    
    public function remove(Kajoa_Model_Conditions $conditions)
    {
        return $this->getAdapter()->delete($conditions->toSql());
    }
    
    public function select()
    {
        require_once 'Zend/Db/Select.php';
        return $this->getAdapter()->getTable()->select();
    }
    
    public function update(array $data, Kajoa_Model_Conditions $conditions)
    {
        return $this->getAdapter()->update($data, $conditions->toSql());
    }
}