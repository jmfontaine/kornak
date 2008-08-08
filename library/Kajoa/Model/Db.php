<?php
class Kajoa_Model_Db extends Kajoa_Model_Abstract
{
    protected $_table;
    
    public function __construct()
    {
        $class = get_class($this) . '_Table';
        $this->_table = new $class();
    }
    
    public function add(array $data)
    {
        return $this->_table->insert($data);
    }
    
    public function create()
    {
        return $this->_table->fetchNew();
    }
    
    public function getAll(Kajoa_Model_Conditions $conditions = null, $fields = '*', $orderBy = null, $limit = null)
    {
        $tableName = $this->_table->info(Zend_Db_Table_Abstract::NAME);
        $select = $this->_table->select();
        $select->from($tableName, $fields);
        
        if(null !== $conditions) {
            $select->where($conditions);
        }
        
        if(null !== $orderBy) {
            $select->order($orderBy);
        }
        
        if(null !== $limit) {
            $select->limit($limit);
        }
        
        return $this->_table->fetchAll($select);
    }
    
    public function getById($id)
    {
        return $this->_table->find($id)->current();
    }

    public function getPaginator($itemsPerPage = 10, $pageNumber = null, $selector = null)
    {
        if (null === $selector) {
            $selector = $this->_table->select();
        }
        
        if (!$selector instanceof Zend_Db_Select) {
            throw new Kajoa_Exception('$selector must be a instance of the Zend_Db_Select class');
        }
        
        $paginator = new Zym_Paginate_DbTable($this->_table, $selector);
        $paginator->setRowLimit($itemsPerPage);
        
        if (null !== $pageNumber && $paginator->hasPageNumber($pageNumber)) {
            $paginator->setCurrentPageNumber($pageNumber);
        }

        return $paginator;
    }
    
    /**
     * Get associate array with $key as array key and $value as array value
     * $orderBy specify the ordonate field.
     * $orderBy could be a string or an array
     * 
     * Example : 
     * $orderBy = array('field1', 'field2' => 'DESC', 'field3' => 'ASC');
     * 
     * @param string $key
     * @param string $value
     * @param mixed $orderBy
     * @return array
     */
    public function getPairs($key, $value, $orderBy = null)
    {
        $fields = array($key, $value);
        
        $tableName = $this->_table->info(Zend_Db_Table_Abstract::NAME);
        
        $select = $this->_table->select();
        $select->from($tableName, $fields);
        
        $order = array();
        if (null !== $orderBy) {
            if (is_string($orderBy)) {
                $order = $orderBy . ' ASC'; 
            } elseif (is_array($orderBy)) {
                foreach ($orderBy as $key => $value) {
                    if (is_int($key)) {
                        $order[] = $value . ' ASC';
                    } else {
                        $order[] = $key . ' ' . $value;
                    } 
                }
            } else {
                throw new Kajoa_Exception('"$orderBy" must be a string or an array');
            }
            $select->order($order);
        }
        return $this->_table->getAdapter()->fetchPairs($select);
    }
    
    public function getRandom($count = 10, Kajoa_Model_Conditions $conditions = null)
    {
        $tableName = $this->_table->info(Zend_Db_Table_Abstract::NAME);
        
        $select = $this->_table->select();
        $select->from($tableName);
        $select->order('RAND()');
        $select->limit($count);
        
        if (null !== $conditions) {
            $select->where($conditions->toSql());
        }
        
        return $this->_table->fetchAll($select);
    }
    
    public function remove(Kajoa_Model_Conditions $conditions)
    {
        return $this->_table->delete($conditions->toSql());
    }
    
    public function update(array $data, Kajoa_Model_Conditions $conditions)
    {
        return $this->_table->update($data, $conditions->toSql());
    }
}