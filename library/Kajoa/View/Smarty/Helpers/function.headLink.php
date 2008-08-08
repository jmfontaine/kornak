<?php
function smarty_function_headLink($parameters, $smarty)
{
    $helper = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view->headLink();    
    
    $allowedMethods = array('prepend', 'set', 'append');    
    
    // Add stylesheet
    if (isset($parameters['stylesheet'])) {
        if (!empty($parameters['method']) && in_array($parameters['method'], $allowedMethods)) {
            $method = strtolower($parameters['method']) . 'Stylesheet';
        } else {
            $method = 'appendStylesheet';
        }
        $helper->$method($parameters['stylesheet']);
    } elseif (isset($parameters['alternate'])) {
    // Add alternate stylesheet
        if (empty($parameters['type'])) {
            $type = 'text/css';
        } else {
            $type = $parameters['type'];
        }
        
        if (empty($parameters['title'])) {
            throw new Kajoa_Exception('Missing alternate head link title');
        }
        
        if (!empty($parameters['method']) && in_array($parameters['method'], $allowedMethods)) {
            $method = strtolower($parameters['method']) . 'Alternate';
        } else {
            $method = 'appendAlternate';
        }
        $helper->$method($parameters['alternate'], $parameters['type'], $parameters['title']);
    } else {
    // Display
        return (string) $helper;
    }
}