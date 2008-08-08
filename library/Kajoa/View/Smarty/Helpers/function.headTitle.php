<?php
function smarty_function_headTitle($parameters, $smarty)
{
    $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view->headTitle();    
    
    // Add part
    if (!empty($parameters['title'])) {
        $allowedMethods = array('prepend', 'set', 'append');    
        if (!empty($parameters['method']) && in_array($parameters['method'], $allowedMethods)) {
            $method = strtolower($parameters['method']);
        } else {
            $method = 'append';
        }
        $helper->headTitle($parameters['title'], $method);
    } else {
    // Display title
        return (string) $helper;
    }
}