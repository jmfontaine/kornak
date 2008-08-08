<?php
function smarty_block_headStyleBlock($parameters, $content, $smarty, $repeat)
{
    if(!$repeat){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view->headStyle();    
        
        $allowedMethods = array('prepend', 'set', 'append');    
        if (!empty($parameters['method']) && in_array($parameters['method'], $allowedMethods)) {
            $method = strtolower($parameters['method']) . 'Style';
        } else {
            $method = 'appendStyle';
        }
        $helper->$method($content);
    }
} 