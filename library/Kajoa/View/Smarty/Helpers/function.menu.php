<?php
function smarty_function_menu($parameters, $smarty)
{
    $name = isset($parameters['name']) ? $parameters['name'] : 'default';
    
    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
    return (string) $viewRenderer->view->menu($name);    
}