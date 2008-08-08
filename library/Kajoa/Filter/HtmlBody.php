<?php
class Kajoa_Filter_HtmlBody extends Kajoa_Filter_HtmlPurifier
{
    protected function _getCurrentDoctype()
    {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $doctype      = $viewRenderer->view->doctype()->getDoctype();
            
        switch ($doctype) {
            case Zend_View_Helper_Doctype::XHTML1_STRICT:
                $result = 'XHTML 1.0 Strict';
                break;
            case Zend_View_Helper_Doctype::XHTML1_TRANSITIONAL:
            case Zend_View_Helper_Doctype::XHTML1_FRAMESET:
                $result = 'XHTML 1.0 Transitional';
                break;
            case Zend_View_Helper_Doctype::HTML4_STRICT:
                $result = 'HTML 4.01 Strict';
                break;
            case Zend_View_Helper_Doctype::HTML4_LOOSE:
            case Zend_View_Helper_Doctype::HTML4_FRAMESET:
                $result = 'HTML 4.01 Transitional';
                break;
            default:
                $result = null;
        }
        
        return $result;        
    }
    
    public function __construct($customOptions = array())
    {
        $options = array(
            'HTML.Doctype' => $this->_getCurrentDoctype(),
            'HTML.Allowed' => 'address,a[href],b,blockquote,br,em,h1,h2,h3,h4,h5,hr,i,li,ol,p[style],pre,strong,ul',
        );
        
        if (!is_null($customOptions)) {
            $options = array_merge($options, $customOptions);
        }
       
        parent::__construct($options);
    }
}