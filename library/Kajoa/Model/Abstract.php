<?php
abstract class Kajoa_Model_Abstract
{
    abstract public function add(array $data);

    abstract public function create();
    
    abstract public function getAll(Kajoa_Model_Conditions $conditions = null,
        $fields = '*', $orderBy = null, $limit = null);
    
    abstract public function getById($id);
    
    abstract public function getOne(Kajoa_Model_Conditions $conditions = null,
        $fields = '*');
    
    abstract public function getPaginator($itemsPerPage = 10,
        $pageNumber = null, $selector = null);
    
    abstract public function getPairs($key, $value, $orderBy = null);
    
    abstract public function getRandom($count = 10,
        Kajoa_Model_Conditions $conditions = null);
    
    abstract public function remove(Kajoa_Model_Conditions $conditions);
    
    public function removeById($id)
    {
        $conditions = new Kajoa_Model_Conditions('id', $id);
        return $this->remove($conditions);
    }
    
    abstract public function update(array $data,
        Kajoa_Model_Conditions $conditions);
    
    public function updateById(array $data, $id)
    {
        $conditions = new Kajoa_Model_Conditions('id', $id);
        return $this->update($data, $conditions);
    }
}