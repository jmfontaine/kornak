<?php
function smarty_function_inlineScript($parameters, $smarty)
{
    $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view->inlineScript();    
    
    // Add file
    if (!empty($parameters['file'])) {
        $allowedMethods = array('prepend', 'set', 'append');    
    
        if (!empty($parameters['method']) && in_array($parameters['method'], $allowedMethods)) {
            $method = strtolower($parameters['method']) . 'File';
        } else {
            $method = 'appendFile';
        }
        $helper->$method($parameters['file']);
    } else {
    // Display    
        return (string) $helper;
    }    
}