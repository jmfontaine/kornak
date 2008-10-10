<?php
require_once 'Zend/View/Helper/Placeholder/Container/Abstract.php';
require_once 'Zend/View/Helper/Placeholder/Container/Standalone.php';

class Kajoa_View_Helper_BodyClass extends Zend_View_Helper_Placeholder_Container_Standalone
{
    protected $_regKey = 'Kajoa_View_Helper_BodyClass';
    
    public function bodyClass($class = null, $setType = Zend_View_Helper_Placeholder_Container_Abstract::APPEND)
    {
        if ($class) {
            if ($setType == Zend_View_Helper_Placeholder_Container_Abstract::SET) {
                $this->set($class);
            } elseif ($setType == Zend_View_Helper_Placeholder_Container_Abstract::PREPEND) {
                $this->prepend($class);
            } else {
                $this->append($class);
            }
        }
        
        return $this;
    }

    public function toString($indent = null)
    {
        $indent = (null !== $indent)
                ? $this->getWhitespace($indent)
                : $this->getIndent();

        $items = array();
        foreach ($this as $item) {
            $items[] = $item;
        }

        return $indent . implode(' ', $items);
    }

    public function __toString()
    {
        return $this->toString();
    }
}