<?php
function smarty_block_inlineScriptBlock($parameters, $content, $smarty, $repeat)
{
    if(!$repeat){
        $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view->inlineScript();    
        
        $allowedMethods = array('prepend', 'set', 'append');    
        if (!empty($parameters['method']) && in_array($parameters['method'], $allowedMethods)) {
            $method = strtolower($parameters['method']) . 'Script';
        } else {
            $method = 'appendScript';
        }
        $helper->$method($content);
    }
} 