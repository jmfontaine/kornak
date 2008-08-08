<?php
function smarty_function_headMeta($parameters, $smarty)
{
    $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view->headMeta();    
    
    $allowedMethods = array('prepend', 'set', 'append');    
    
    // Add named metatag
    if (!empty($parameters['name'])) {
        if (!empty($parameters['method']) && in_array($parameters['method'], $allowedMethods)) {
            $method = strtolower($parameters['method']) . 'Name';
        } else {
            $method = 'appendName';
        }
        $helper->$method($parameters['name'], $parameters['content']);
    } elseif (!empty($parameters['httpEquiv'])) {
    // Add HTTP-Equiv metatag
        if (!empty($parameters['method']) && in_array($parameters['method'], $allowedMethods)) {
            $method = strtolower($parameters['method']) . 'HttpEquiv';
        } else {
            $method = 'appendHttpEquiv';
        }
        $helper->$method($parameters['httpEquiv'], $parameters['content']);
    } else {
    // Display
        return (string) $helper;
    }
}