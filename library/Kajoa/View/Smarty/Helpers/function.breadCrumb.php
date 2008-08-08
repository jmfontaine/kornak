<?php
function smarty_function_breadCrumb($parameters, $smarty)
{
    $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view->breadCrumb();    
    
    // Add part
    if (!empty($parameters['text'])) {
        $allowedMethods = array('prepend', 'set', 'append');    
        if (!empty($parameters['method']) && in_array($parameters['method'], $allowedMethods)) {
            $method = strtolower($parameters['method']);
        } else {
            $method = 'append';
        }
        $helper->breadCrumb($parameters['text'], $method);
    } else {
    // Display title
        return (string) $helper;
    }
}