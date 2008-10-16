<?php
require_once 'Kajoa/Db/Table.php';

class Kajoa_Model_Adapter_Dbtable
{
    protected $_table;

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->_table, $name), $arguments);
    }
    
    public function __construct($options = array())
    {
        $this->_table = new Kajoa_Db_Table($options);
    }
     
    public function getTable()
    {
        return $this->_table;
    }

    public function setTable(Kajoa_Db_Table $table)
    {
        $this->_table = $table;
    }
}