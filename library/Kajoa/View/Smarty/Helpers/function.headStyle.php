<?php
function smarty_function_headStyle($parameters, $smarty)
{
    return (string) Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view->headStyle();    
}