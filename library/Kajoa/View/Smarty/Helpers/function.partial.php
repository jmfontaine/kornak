<?php
function smarty_function_partial($parameters, $smarty)
{
    if (empty($parameters['name'])) {
         throw new Kajoa_Exception('Missing "name" attribute');
    } else {
        $name = 'partial/' . $parameters['name'] . '.tpl';
        unset($parameters['name']);
    }

    $view = &$smarty->get_template_vars('this');
    
    $helper = new Zend_View_Helper_Partial;
    $helper->setView($view);
    return $helper->partial($name, $parameters);
}