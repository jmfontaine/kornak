<?php
function smarty_function_headScript($parameters, $smarty)
{
    return (string) Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer')->view->headScript();
}