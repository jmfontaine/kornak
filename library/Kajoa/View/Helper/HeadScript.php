<?php
class Kajoa_View_Helper_HeadScript extends Zend_View_Helper_HeadScript
{
    protected $_hashes = array();
    
    protected function _isDuplicateScript($script)
    {
        $hash = hash('sha1', $script);
        if (in_array($hash, $this->_hashes)) {
            return true;
        } else {
            $this->_hashes[] = $hash;
            return false;
        }
    }
    
    public function __call($method, $args)
    {
        $methods = array('prependScript', 'setScript', 'appendScript');
        if (in_array($method, $methods)) {
            $content = $args[0];
            if ($this->_isDuplicateScript($content)) {
                return false;                 
            }
        }
        return parent::__call($method, $args);       
    }    
}
