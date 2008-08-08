<?php
function smarty_function_doctype($parameters, $smarty)
{
    $doctype = !empty($parameters['name']) ? $parameters['name'] : null; 

    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
    return (string) $viewRenderer->view->doctype($doctype);    
}