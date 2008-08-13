<?php
class Kajoa_View_Helper_BreadCrumb extends
    Zend_View_Helper_Placeholder_Container_Standalone
{
    protected $_regKey = 'Kajoa_View_Helper_BreadCrumb';

    protected function _createData($text, $url)
    {
        $data = new StdClass();
        $data->text = $text;
        
        if (is_array($url)) {
            $options = isset($url['options']) ? $url['options'] : array();
            $name    = isset($url['name']) ? $url['name'] : null;
            $reset   = isset($url['reset']) ? (bool) $url['reset'] : false;
            $encode  = isset($url['encode']) ? (bool) $url['encode'] : true;
            
            $url = $this->view->url($options, $name, $reset, $encode);            
        }
        $data->url = (string) $url;
        
        return $data;
    }
    
    /**
     * 
     *
     * @param string $text
     * @param string|array $url
     * @param int $setType
     * @return Kajoa_View_Helper_BreadCrumb
     */
    public function breadCrumb($text = null, $url = null,
            $setType = Zend_View_Helper_Placeholder_Container_Abstract::APPEND)
    {
        $data = $this->_createData($text, $url);
        
        if ($text) {
            if ($setType == Zend_View_Helper_Placeholder_Container_Abstract::SET) {
                $this->set($data);
            } elseif ($setType == Zend_View_Helper_Placeholder_Container_Abstract::PREPEND) {
                $this->prepend($data);
            } else {
                $this->append($data);
            }
        }
        
        return $this;
    }

    /**
     * Turn helper into string
     * 
     * @param  string|null $indent 
     * @return string
     */
    public function toString($indent = null)
    {
        $indent = (null !== $indent)
                ? $this->getWhitespace($indent)
                : $this->getIndent();

        $items = array();
        foreach ($this as $item) {
            if (!empty($item->url)) {
                $items[] = sprintf('<a href="%s">%s</a>', $item->url,
                                   $this->_escape($item->text));
            } else {
               $items[] = $this->_escape($item->text);  
            }
        }

        $separator = $this->_escape($this->getSeparator());
        if (empty($separator)) {
            $separator = ' > ';
        }

        return $indent . '<p class="breadcrumb">' . implode($separator, $items) . '</p>';
    }

    /**
     * Cast to string
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
