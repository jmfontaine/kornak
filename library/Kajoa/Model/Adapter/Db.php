<?php
class Kajoa_Model_Adapter_Db
{
    protected $_db;

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->_db, $name), $arguments);
    }
    
    public function __construct($options = array())
    {
        if (empty($options)) {
            require_once 'Kajoa/Application.php';
            $this->_db = Kajoa_Application::getInstance()
                                          ->getAspect('db')
                                          ->getConnection();    
        } else {
            $adapter = $options['adapter'];
            unset($options['adapter']);
            require_once 'Zend/Db.php';
            $this->_db = Zend_Db::factory($adapter, $options);
        }
        
        $this->_db->setFetchMode(Zend_Db::FETCH_ASSOC);
    }
}