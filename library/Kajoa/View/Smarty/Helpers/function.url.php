<?php
function smarty_function_url($parameters, $smarty)
{
    $route  = 'default';
    $reset  = true;    
    
    if (empty($parameters)) {
       return Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
    }
    
    if (!empty($parameters['reset'])) {
        $reset = (bool) $parameters['reset'];
        unset($parameters['reset']);
    }

    if (!empty($parameters['route'])) {
        $route = $parameters['route'];
        unset($parameters['route']);
    }
    
    $urlHelper = new Zend_View_Helper_Url();
    return $urlHelper->url($parameters, $route, $reset);
}